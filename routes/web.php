<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirigir la raíz al login o al panel correspondiente según el rol
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->is_admin 
            ? redirect()->route('admin.users.index') 
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard inteligente: si es admin, va al panel de administración
Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.users.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil de usuario normal
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas protegidas para el Administrador
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/membership', [AdminController::class, 'updateMembership'])->name('users.updateMembership');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';