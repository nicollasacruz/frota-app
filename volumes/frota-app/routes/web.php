<?php

use App\Http\Controllers\PaymentDriverController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('usuarios')->group(function () {
        Route::get('/criar', [ProfileController::class, 'create'])->name('usuarios.create');
        Route::get('/', [ProfileController::class, 'index'])->name('usuarios.index');
        Route::post('/', [ProfileController::class, 'store'])->name('usuarios.store');
        Route::get('/{driver}', [ProfileController::class, 'show'])->name('usuarios.show')->where('driver', '[0-9]+');
        Route::get('/{driver}/editar', [ProfileController::class, 'edit'])->name('usuarios.edit')->where('driver', '[0-9]+');
        Route::get('/{driver}/editar-motorista', [ProfileController::class, 'editDriver'])->name('usuarios.editDriver')->where('driver', '[0-9]+');
        Route::patch('/{user}', [ProfileController::class, 'update'])->name('usuarios.update')->where('user', '[0-9]+');
        Route::delete('/{driver}', [ProfileController::class, 'destroy'])->name('usuarios.destroy')->where('driver', '[0-9]+');
    });

    Route::prefix('pagamentos')->group(function () {
        Route::get('/criar', [PaymentDriverController::class, 'create'])->name('pagamentos.create');
        Route::get('/', [PaymentDriverController::class, 'index'])->name('pagamentos.index');
        Route::post('/', [PaymentDriverController::class, 'store'])->name('pagamentos.store');
        Route::get('/{payment}', [PaymentDriverController::class, 'show'])->name('pagamentos.show')->where('payment', '[0-9]+');
        Route::get('/{payment}/editar', [PaymentDriverController::class, 'edit'])->name('pagamentos.edit')->where('payment', '[0-9]+');
        Route::patch('/{payment}', [PaymentDriverController::class, 'update'])->name('pagamentos.update')->where('payment', '[0-9]+');
        Route::delete('/{payment}', [PaymentDriverController::class, 'destroy'])->name('pagamentos.destroy')->where('payment', '[0-9]+');
    });
});



require __DIR__.'/auth.php';
