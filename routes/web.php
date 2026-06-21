<?php

use App\Http\Controllers\RecetaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

// Rutas para el CRUD de Recetas
Route::prefix('recetas')->group(function () {
    Route::get('/', [RecetaController::class, 'index'])->name('recipes.index');
    Route::post('/', [RecetaController::class, 'store'])->name('recipes.store');
    Route::put('/{receta}', [RecetaController::class, 'update'])->name('recipes.update');
    Route::delete('/{receta}', [RecetaController::class, 'destroy'])->name('recipes.destroy');
});
