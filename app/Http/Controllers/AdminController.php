<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Listar todos los usuarios y gestionar sus membresías
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Actualizar la membresía de un usuario
    public function updateMembership(Request $request, User $user)
    {
        $request->validate([
            'membership_status' => 'required|in:active,inactive,expired',
            'membership_expires_at' => 'nullable|date',
        ]);

        $user->update([
            'membership_status' => $request->membership_status,
            'membership_expires_at' => $request->membership_expires_at,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Membresía actualizada con éxito.');
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'No se puede eliminar al usuario administrador principal.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}