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

        if (!$user->hasActiveMembership()) {
            return redirect()->route('membership.pending');
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

        if (!$user->hasActiveMembership()) {
            return redirect()->route('membership.pending');
        }

        if ($user->company) {
            return redirect()->route('dashboard')
                ->with('success', 'Tu empresa ya se encuentra registrada.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nit' => 'required|string|max:50',
            'society_type' => ['required', Rule::in([
                'Empresa Unipersonal',
                'Sociedad de Responsabilidad Limitada (S.R.L.)',
                'Sociedad Anónima (S.A.)',
                'Sociedad Colectiva',
                'Sociedad en Comandita Simple',
                'Sociedad en Comandita por Acciones',
                'Asociación Accidental o de Cuentas en Participación',
                'Otro',
            ])],
            'economic_activity' => 'required|string|max:255',
            'activity_category' => ['required', Rule::in([
                'comercio','servicios','industria','construccion',
                'transporte','profesional','agropecuaria','otra'
            ])],
            'business_operations' => 'nullable|array',
            'business_operations.*' => ['string', Rule::in([
                'compra_venta','importaciones','exportaciones','ventas_credito',
                'ventas_contado','inventario','servicios_adicionales',
                'recibe_parte_pago','fabricacion','contratos'
            ])],
            'tax_regime' => ['required', Rule::in([
                'general','simplificado','integrado','agropecuario','otro','no_sabe'
            ])],
            'tax_obligations' => 'nullable|array',
            'tax_obligations.*' => ['string', Rule::in([
                'iva_200','it_400','iue_500','it_retenciones_410',
                'iue_retenciones_570','rciva_retenciones_604','no_sabe'
            ])],
            'sin_registration_verified' => 'required|in:0,1',
            'has_employees' => 'required|in:0,1',
            'fiscal_address' => 'required|string|max:500',
            'legal_representative' => 'required|string|max:255',
            'currency' => 'required|in:BOB,USD',
            'fiscal_period' => 'required|integer|min:2000|max:2100',
        ]);

        $validated['business_operations'] = array_values($validated['business_operations'] ?? []);
        $validated['tax_obligations'] = array_values($validated['tax_obligations'] ?? []);
        $validated['has_employees'] = (bool) $validated['has_employees'];
        $validated['sin_registration_verified'] = (bool) $validated['sin_registration_verified'];

        $user->company()->create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Empresa registrada. Hemos preparado su perfil inicial; revisa las obligaciones tributarias con tu RNC antes de declarar.');
    }
}
