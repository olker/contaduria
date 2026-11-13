<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\PlanAccount;
use App\Models\PlanAccountObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpeningBalanceController extends Controller
{
    private function currentCompany()
    {
        $user = auth()->user();
        if ($user->membership_status !== 'active') return null;
        return $user->company;
    }

    private function accountGroups($accounts)
    {
        $typeNames = [
            'activo' => 'ACTIVO',
            'pasivo' => 'PASIVO',
            'patrimonio' => 'PATRIMONIO',
        ];

        $groups = [];
        foreach ($accounts as $account) {
            $type = $typeNames[$account->group_type] ?? strtoupper($account->group_type);
            $section = $account->parent ? trim($account->parent->name) : 'OTRAS CUENTAS';
            // Si el padre es una cuenta intermedia, se muestra como subtítulo.
            $groups[$type][$section][] = $account;
        }
        return $groups;
    }

    private function accountSection(PlanAccount $account)
    {
        $node = $account;
        while ($node->parent) {
            if ((int) $node->parent->level <= 3) {
                return trim($node->parent->name);
            }
            $node = $node->parent;
        }
        return 'OTRAS CUENTAS';
    }

    public function index()
    {
        $company = $this->currentCompany();
        if (!$company) {
            return redirect()->route('dashboard')->with('error', 'Necesitas una membresía activa y una empresa registrada para acceder al Libro de Apertura.');
        }

        $openingEntry = JournalEntry::with('lines.account.parent.parent')
            ->where('company_id', $company->id)
            ->where('type', 'apertura')
            ->latest('date')->first();

        $activeGroups = [];
        $passiveGroups = [];
        $equityGroups = [];

        if ($openingEntry) {
            foreach ($openingEntry->lines as $line) {
                $account = $line->account;
                $section = $this->accountSection($account);

                if ($account->group_type === 'activo') {
                    $activeGroups[$section][] = $line;
                } elseif ($account->group_type === 'pasivo') {
                    $passiveGroups[$section][] = $line;
                } elseif ($account->group_type === 'patrimonio') {
                    $equityGroups[$section][] = $line;
                }
            }
        }

        return view('cliente.opening.index', compact(
            'company', 'openingEntry', 'activeGroups', 'passiveGroups', 'equityGroups'
        ));
    }

    public function create()
    {
        $company = $this->currentCompany();
        if (!$company) {
            return redirect()->route('dashboard')->with('error', 'Necesitas una membresía activa y una empresa registrada para acceder al Libro de Apertura.');
        }

        if (JournalEntry::where('company_id', $company->id)->where('type', 'apertura')->exists()) {
            return redirect()->route('opening.index')->with('error', 'Ya existe un Libro de Apertura registrado para esta empresa.');
        }

        $accounts = PlanAccount::with('parent.parent')
            ->whereIn('group_type', ['activo', 'pasivo', 'patrimonio'])
            ->where('allows_entries', true)
            ->orderBy('source_order')->get(['id', 'code', 'name', 'group_type', 'parent_id']);

        $accountGroups = [];
        $labels = ['activo' => 'ACTIVO', 'pasivo' => 'PASIVO', 'patrimonio' => 'CAPITAL Y RESERVA'];
        foreach ($accounts as $account) {
            $section = $account->parent ? trim($account->parent->name) : 'OTRAS CUENTAS';
            $accountGroups[$labels[$account->group_type] ?? strtoupper($account->group_type)][$section][] = $account;
        }

        return view('cliente.opening.create', compact('company', 'accounts', 'accountGroups'));
    }

    public function print()
    {
        $company = $this->currentCompany();
        if (!$company) {
            return redirect()->route('dashboard')->with('error', 'No tienes acceso al Libro de Apertura.');
        }

        $entry = JournalEntry::with('lines.account.parent.parent')
            ->where('company_id', $company->id)
            ->where('type', 'apertura')->latest('date')->first();

        if (!$entry) {
            return redirect()->route('opening.index')->with('error', 'Primero debes registrar el Libro de Apertura.');
        }

        $activeGroups = [];
        $rightGroups = ['pasivo' => [], 'patrimonio' => []];

        foreach ($entry->lines as $line) {
            $account = $line->account;
            $section = $this->accountSection($account);
            $item = [
                'code' => $account->code,
                'name' => trim($account->name),
                'debit' => (float) $line->debit,
                'credit' => (float) $line->credit,
            ];

            if ($account->group_type === 'activo') {
                $activeGroups[$section][] = $item;
            } elseif ($account->group_type === 'pasivo') {
                $rightGroups['pasivo'][$section][] = $item;
            } else {
                $rightGroups['patrimonio'][$section][] = $item;
            }
        }

        $totalActive = $entry->lines->sum(fn ($line) => (float) $line->debit);
        $totalRight = $entry->lines->sum(fn ($line) => (float) $line->credit);

        return view('cliente.opening.print', compact(
            'company', 'entry', 'activeGroups', 'rightGroups', 'totalActive', 'totalRight'
        ));
    }

    public function observations()
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard');
        $observations = PlanAccountObservation::orderBy('source_page')->orderBy('id')->get();
        return view('cliente.opening.observations', compact('company', 'observations'));
    }

    public function store(Request $request)
    {
        $company = $this->currentCompany();
        if (!$company) return redirect()->route('dashboard')->with('error', 'No tienes acceso al Libro de Apertura.');

        if (JournalEntry::where('company_id', $company->id)->where('type', 'apertura')->exists()) {
            return redirect()->route('opening.index')->with('error', 'Ya existe un Libro de Apertura registrado para esta empresa.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'lines' => ['required', 'array', 'min:2'],
            'lines.*.account_id' => ['required', 'integer', 'distinct', 'exists:plan_accounts,id'],
            'lines.*.description' => ['nullable', 'string', 'max:500'],
            'lines.*.debit' => ['required', 'numeric', 'min:0'],
            'lines.*.credit' => ['required', 'numeric', 'min:0'],
        ]);

        if ((int) date('Y', strtotime($validated['date'])) !== (int) $company->fiscal_period) {
            throw ValidationException::withMessages(['date' => 'La fecha del asiento debe pertenecer a la gestión fiscal ' . $company->fiscal_period . '.']);
        }

        $accountIds = collect($validated['lines'])->pluck('account_id')->map(fn ($id) => (int) $id);
        $allowedAccounts = PlanAccount::whereIn('id', $accountIds)
            ->whereIn('group_type', ['activo', 'pasivo', 'patrimonio'])
            ->where('allows_entries', true)->get()->keyBy('id');

        if ($allowedAccounts->count() !== $accountIds->unique()->count()) {
            throw ValidationException::withMessages(['lines' => 'Selecciona únicamente cuentas auxiliares de Activo, Pasivo o Patrimonio.']);
        }

        $totalDebitCents = 0;
        $totalCreditCents = 0;
        foreach ($validated['lines'] as $index => $line) {
            $debit = (int) round(((float) $line['debit']) * 100);
            $credit = (int) round(((float) $line['credit']) * 100);
            $selectedAccount = $allowedAccounts[(int) $line['account_id']];
            if ($selectedAccount->group_type === 'activo' && $credit > 0) {
                throw ValidationException::withMessages(['lines.' . $index => 'Las cuentas de Activo deben registrarse en el Debe, no en el Haber.']);
            }
            if (in_array($selectedAccount->group_type, ['pasivo', 'patrimonio'], true) && $debit > 0) {
                throw ValidationException::withMessages(['lines.' . $index => 'Las cuentas de Pasivo y Patrimonio deben registrarse en el Haber, no en el Debe.']);
            }
            if ($debit > 0 && $credit > 0) {
                throw ValidationException::withMessages(['lines.' . $index => 'Una línea no puede tener importe en Debe y Haber al mismo tiempo.']);
            }
            if ($debit === 0 && $credit === 0) {
                throw ValidationException::withMessages(['lines.' . $index => 'Cada línea debe tener un importe en Debe o en Haber.']);
            }
            $totalDebitCents += $debit;
            $totalCreditCents += $credit;
        }

        if ($totalDebitCents <= 0 || $totalDebitCents !== $totalCreditCents) {
            throw ValidationException::withMessages(['lines' => 'El asiento debe estar cuadrado: Debe y Haber deben ser iguales y mayores que cero.']);
        }

        DB::transaction(function () use ($validated, $company, $allowedAccounts) {
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
                'company_id' => $company->id,
                'date' => $validated['date'],
                'description' => $validated['description'],
                'type' => 'apertura',
                'entry_code' => 'AD1',
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
        });

        return redirect()->route('opening.index')->with('success', 'El Libro de Apertura se registró correctamente y el asiento está cuadrado.');
    }
}
