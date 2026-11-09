<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Dashboard Inteligente: Detecta si es Admin o Cliente
    public function index()
    {
        $user = auth()->user();

        // SI ES ADMINISTRADOR: Redirigir de inmediato a su panel de gestión
        if ($user->is_admin) {
            return redirect()->route('admin.users.index');
        }

        // SI ES CLIENTE: Cargar su empresa
        $company = $user->company;

        return view('cliente.dashboard', compact('company'));
    }

    // Formulario para crear empresa
    public function create()
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.users.index');
        }

        if (auth()->user()->company) {
            return redirect()->route('dashboard');
        }

        // Nota: Asegúrate de tener esta vista creada en resources/views/cliente/company/create.blade.php 
        // o ajusta la ruta si la tienes en otra carpeta.
        return view('cliente.company.create');
    }

    // Guardar datos de la empresa de práctica
    public function store(Request $request)
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.users.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nit' => 'required|string|max:50',
            'currency' => 'required|string|max:10',
            'fiscal_period' => 'required|integer|min:2000|max:2100',
        ]);

        Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'nit' => $request->nit,
            'currency' => $request->currency,
            'fiscal_period' => $request->fiscal_period,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Empresa configurada exitosamente!');
    }
}