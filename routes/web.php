<?php

use App\Generico\Carrito;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use App\Models\Articulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('principal', [
        'articulos' => Articulo::with(['iva', 'categoria'])->get(),
        'carrito' => carrito(),
    ]);
})->name('principal');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ricardo', function () {
    return view('ricardo');
});

Route::resource('categorias', CategoriaController::class)
    ->middleware('auth');

Route::resource('articulos', ArticuloController::class);

Route::get('/carrito/insertar/{id}', function ($id) {
    $articulo = Articulo::findOrFail($id);
    $carrito = carrito();
    $carrito->insertar($id);
    session()->put('carrito', $carrito);
    return redirect()->route('principal');
})->name('carrito.insertar')->whereNumber('id');

Route::get('/carrito/vaciar', function () {
    session()->forget('carrito');
    return redirect()->route('principal');
})->name('carrito.vaciar');

require __DIR__.'/auth.php';
