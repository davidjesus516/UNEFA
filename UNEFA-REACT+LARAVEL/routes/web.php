<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CursoController; // Importa el nuevo controlador
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí registras las rutas web para tu aplicación.
|
*/

// RUTA PRINCIPAL (HOMEPAGE)
// Renderiza el componente HomePage.jsx
Route::get('/', function () {
    return Inertia::render('HomePage'); 
})->name('home'); 

// RUTAS PROTEGIDAS (Requieren inicio de sesión)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ruta de Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // RUTAS DE GESTIÓN DE CURSOS
    // Cuando el usuario va a /cursos, llama al método index de CursoController
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
});

// Rutas de Perfil (ya existentes)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';