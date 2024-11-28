<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\SearchController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'visitas'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pizzas', [PizzaController::class, 'index'])->middleware(['auth', 'visitas'])->name('pizzas.index');
Route::get('/pizzas/create', [PizzaController::class, 'create'])->middleware(['auth'])->name('pizzas.create');
Route::post('/pizzas', [PizzaController::class, 'store'])->middleware(['auth'])->name('pizzas.store');
Route::get('/pizzas/{pizza}/edit', [PizzaController::class, 'edit'])->middleware(['auth'])->name('pizzas.edit');
Route::put('/pizzas/{pizza}', [PizzaController::class, 'update'])->middleware(['auth'])->name('pizzas.update');
Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy'])->middleware(['auth'])->name('pizzas.destroy');
Route::get('/pizzas/{pizza}', [PizzaController::class, 'show'])->middleware(['auth', 'visitas'])->name('pizzas.show');

Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'visitas'])->name('users.index');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware(['auth'])->name('users.destroy');

Route::get('/cajeros', [CajeroController::class, 'index'])->middleware(['auth', 'visitas'])->name('cajeros.index');

Route::get('/clientes', [ClienteController::class, 'index'])->middleware(['auth', 'visitas'])->name('clientes.index');

Route::get('/carrito', [CarritoController::class, 'index'])->middleware(['auth'])->name('carrito.index');
Route::post('/carrito', [CarritoController::class, 'store'])->middleware(['auth'])->name('carrito.store');

Route::delete('/carrito/{detalle}',[CarritoController::class, 'destroy'])->middleware(['auth'])->name('carrito.destroy');

Route::get('/historial', [HistorialController::class, 'index'])->middleware(['auth'])->name('historial.index');

Route::get('/carrito/{id}/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');

Route::get('/carrito/pagado', [CarritoController::class, 'pagado'])->name('carrito.pagado');

Route::post('/urlcallback', [CarritoController::class, 'urlCallback'])->name('carrito.urlCallback');


Route::post('/carrito/store', [CarritoController::class, 'store'])->name('carrito.store');

Route::post('/actualizarEstadoPedido', [CarritoController::class, 'actualizarEstadoPedido']);
Route::get('/search', [SearchController::class, 'search'])->name('search');

require __DIR__.'/auth.php';
