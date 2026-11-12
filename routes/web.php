<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OpeningBalanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. PORTAL PRINCIPAL
Route::get('/', function () {
    return view('welcome');
});

// 2. PERFIL DE USUARIO
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. PANEL DE ADMINISTRACIÓN (Exclusivo AdminController)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/membership', [AdminController::class, 'updateMembership'])->name('users.updateMembership');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });

// 4. OPERACIÓN DE ESTUDIANTES Y EMPRESA (Exclusivo CompanyController / User)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal del usuario
    Route::get('/dashboard', [CompanyController::class, 'index'])->name('dashboard');

    // Rutas de configuración de la empresa de práctica
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/', [CompanyController::class, 'store'])->name('store');
    });

    // Libro de Apertura: saldo inicial independiente por empresa.
    Route::prefix('libro-apertura')->name('opening.')->group(function () {
        Route::get('/', [OpeningBalanceController::class, 'index'])->name('index');
        Route::get('/crear', [OpeningBalanceController::class, 'create'])->name('create');
        Route::get('/observaciones', [OpeningBalanceController::class, 'observations'])->name('observations');
        Route::get('/imprimir', [OpeningBalanceController::class, 'print'])->name('print');
        Route::post('/', [OpeningBalanceController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';