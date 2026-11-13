<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JournalEntry;
use App\Models\PlanAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JournalController extends Controller
{
    private function currentCompany()
    {
        $user = auth()->user();
        if (!$user || $user->membership_status !== 'active') return null;
        return $user->company;
    }

    private function accountGroups($accounts)
    {
        $labels = [
            'activo' => 'ACTIVO',
            'pasivo' => 'PASIVO',
            'patrimonio' => 'PATRIMONIO',
            'ingreso' => 'INGRESOS',
            'ingresos' => 'INGRESOS',
            'gasto' => 'GASTOS',
            'gastos' => 'GASTOS',
        ];
        $groups = [];
        foreach ($accounts as $account) {
            $type = $labels[$account->group_type] ?? strtoupper($account->group_type);
            $section = $account->parent ? trim($account->parent->name) : 'CUENTAS GENERALES';
            $groups[$type][$section][] = $account;
        }
        return $groups;
    }

    private function nextEntryCode(Company $company): string
    {
        // Llamar con la fila de empresa bloqueada dentro de DB::transaction.
        $codes = JournalEntry::where('company_id', $company->id)
            ->whereNotNull('entry_code')
            ->pluck('entry_code');

        $max = 0;
        foreach ($codes as $code) {
            if (preg_match('/^AD(\d+)$/i', $code, $m)) {
                $max = max($max, (int) $m[1]);
            }
        }
        return 'AD' . ($max + 1);
    }

    public function index()
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard')->with('error', 'Necesitas una membresía activa y una empresa registrada.');

        $opening = JournalEntry::where('company_id', $company->id)
            ->where('type', 'apertura')->first();

        if (!$opening) {
            return redirect()->route('opening.index')->with('error', 'Primero debes registrar el Libro de Apertura. Ese será el asiento AD1 del Libro Diario.');
        }

        // Compatibilidad: asignar AD1 al asiento de apertura antiguo si aún no lo tuviera.
        if (!$opening->entry_code) {
            $opening->entry_code = 'AD1';
            $opening->save();
        }

        $entries = JournalEntry::with('lines.account')
            ->where('company_id', $company->id)
            ->orderByRaw("CASE WHEN type = 'apertura' THEN 0 ELSE 1 END")
            ->orderBy('date')->orderBy('id')->get();

        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entries as $entry) {
            $totalDebit += $entry->lines->sum(fn ($line) => (float) $line->debit);
            $totalCredit += $entry->lines->sum(fn ($line) => (float) $line->credit);
        }

        return view('cliente.journal.index', compact('company', 'entries', 'totalDebit', 'totalCredit'));
    }

    public function create()
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard')->with('error', 'No tienes acceso al Libro Diario.');

        $opening = JournalEntry::where('company_id', $company->id)->where('type', 'apertura')->first();
        if (!$opening) return redirect()->route('opening.index')->with('error', 'Registra primero el Libro de Apertura para crear el asiento AD1.');

        $accounts = PlanAccount::with('parent')
            ->where('allows_entries', true)
            ->orderBy('source_order')
            ->get(['id', 'code', 'name', 'group_type', 'parent_id']);

        $accountGroups = $this->accountGroups($accounts);

        return view('cliente.journal.create', compact('company', 'accounts', 'accountGroups'));
    }

    public function store(Request $request)
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard')->with('error', 'No tienes acceso al Libro Diario.');

        if (!JournalEntry::where('company_id', $company->id)->where('type', 'apertura')->exists()) {
            return redirect()->route('opening.index')->with('error', 'Primero debes registrar el Libro de Apertura.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'lines' => ['required', 'array', 'min:2'],
            'lines.*.account_id' => ['required', 'integer', 'exists:plan_accounts,id'],
            'lines.*.description' => ['nullable', 'string', 'max:500'],
            'lines.*.debit' => ['required', 'numeric', 'min:0'],
            'lines.*.credit' => ['required', 'numeric', 'min:0'],
        ]);

        if ((int) date('Y', strtotime($validated['date'])) !== (int) $company->fiscal_period) {
            throw ValidationException::withMessages([
                'date' => 'La fecha debe pertenecer a la gestión fiscal ' . $company->fiscal_period . '.',
            ]);
        }

        $accountIds = collect($validated['lines'])->pluck('account_id')->map(fn ($id) => (int) $id)->unique();
        $allowedAccounts = PlanAccount::whereIn('id', $accountIds)
            ->where('allows_entries', true)->get()->keyBy('id');

        if ($allowedAccounts->count() !== $accountIds->count()) {
            throw ValidationException::withMessages(['lines' => 'Selecciona cuentas auxiliares válidas del Plan de Cuentas.']);
        }

        $debitCents = 0;
        $creditCents = 0;
        foreach ($validated['lines'] as $i => $line) {
            $debit = (int) round(((float) $line['debit']) * 100);
            $credit = (int) round(((float) $line['credit']) * 100);

            if (($debit > 0 && $credit > 0) || ($debit === 0 && $credit === 0)) {
                throw ValidationException::withMessages([
                    'lines.' . $i => 'Cada línea debe tener un importe únicamente en Debe o en Haber.',
                ]);
            }
            $debitCents += $debit;
            $creditCents += $credit;
        }

        if ($debitCents <= 0 || $debitCents !== $creditCents) {
            throw ValidationException::withMessages([
                'lines' => 'Asiento descuadrado. El total Debe debe ser igual al total Haber.',
            ]);
        }

        $entry = DB::transaction(function () use ($validated, $company, $allowedAccounts) {
            // Evita que dos usuarios generen el mismo código para la misma empresa.
            $lockedCompany = Company::whereKey($company->id)->lockForUpdate()->firstOrFail();
            $code = $this->nextEntryCode($lockedCompany);

            $details = [];
            foreach ($validated['lines'] as $line) {
                $account = $allowedAccounts[(int) $line['account_id']];
                $details[] = [
                    'account_id' => $account->id,
                    'account_code' => $account->code,
                    'account_name' => trim($account->name),
                    'description' => $line['description'] ?? null,
                    'debit' => number_format((float) $line['debit'], 2, '.', ''),
                    'credit' => number_format((float) $line['credit'], 2, '.', ''),
                ];
            }

            $entry = JournalEntry::create([
                'user_id' => auth()->id(),
                'company_id' => $lockedCompany->id,
                'entry_code' => $code,
                'date' => $validated['date'],
                'description' => $validated['description'],
                'type' => 'diario',
                'details' => $details,
            ]);

            foreach ($validated['lines'] as $index => $line) {
                $entry->lines()->create([
                    'plan_account_id' => (int) $line['account_id'],
                    'description' => $line['description'] ?? null,
                    'debit' => $line['debit'],
                    'credit' => $line['credit'],
                    'line_order' => $index + 1,
                ]);
            }

            return $entry;
        });

        return redirect()->route('journal.index')
            ->with('success', 'Asiento ' . $entry->entry_code . ' registrado correctamente.');
    }

    public function show(JournalEntry $entry)
    {
        $company = $this->currentCompany();
        abort_unless($company && (int) $entry->company_id === (int) $company->id, 404);

        $entry->load('lines.account');
        return view('cliente.journal.show', compact('company', 'entry'));
    }

    public function print()
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard');

        $entries = JournalEntry::with('lines.account')
            ->where('company_id', $company->id)
            ->orderByRaw("CASE WHEN type = 'apertura' THEN 0 ELSE 1 END")
            ->orderBy('date')->orderBy('id')->get();

        return view('cliente.journal.print', compact('company', 'entries'));
    }
}
