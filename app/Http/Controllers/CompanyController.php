<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin.users.index');
        }

        $company = $user->company;

        return view('cliente.dashboard', compact('company'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin.users.index');
        }

        if ($user->company) {
            return redirect()->route('dashboard')
                ->with('success', 'Tu empresa ya se encuentra registrada.');
        }

        return view('cliente.company.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin.users.index');
        }

        if ($user->company) {
            return redirect()->route('dashboard')
                ->with('success', 'Tu empresa ya se encuentra registrada.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nit' => 'required|string|max:50',
            'society_type' => [
                'required',
                Rule::in([
                    'Empresa Unipersonal',
                    'Sociedad de Responsabilidad Limitada (S.R.L.)',
                    'Sociedad Anónima (S.A.)',
                    'Sociedad Colectiva',
                    'Sociedad en Comandita Simple',
                    'Sociedad en Comandita por Acciones',
                    'Asociación Accidental o de Cuentas en Participación',
                    'Otro',
                ]),
            ],
            'economic_activity' => 'required|string|max:255',
            'fiscal_address' => 'required|string|max:500',
            'legal_representative' => 'required|string|max:255',
            'currency' => 'required|in:BOB,USD',
            'fiscal_period' => 'required|integer|min:2000|max:2100',
        ]);

        $user->company()->create($validated);

        return redirect()->route('dashboard')
            ->with('success', '¡Empresa registrada correctamente! Ahora puedes configurar tu balance inicial.');
    }
}
