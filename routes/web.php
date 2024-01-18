<?php

use App\Generico\Carrito;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProfileController;
use App\Mail\PedidoGenerado;
use App\Models\Articulo;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

Route::view('/ricardo', 'ricardo');

Route::resource('categorias', CategoriaController::class)
    ->middleware('auth');

Route::resource('articulos', ArticuloController::class);

Route::get('/cambiar_imagen/{articulo}', [ArticuloController::class, 'cambiar_imagen'])
    ->name('articulos.cambiar_imagen')->whereNumber('articulo');

Route::post('/cambiar_imagen/{articulo}', [ArticuloController::class, 'guardar_imagen'])
->name('articulos.guardar_imagen')->whereNumber('articulo');

Route::get('/carrito/insertar/{id}', [CarritoController::class, 'insertar'])
    ->name('carrito.insertar')->whereNumber('id');

Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])
    ->name('carrito.eliminar')->whereNumber('id');

Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])
    ->name('carrito.vaciar');

Route::get('/comprar', function () {
    return view('comprar', [
        'carrito' => carrito(),
    ]);
})->middleware('auth')->name('comprar');

Route::post('/realizar_compra', function (Request $request) {
    $carrito = carrito();
    DB::beginTransaction();
    $factura = new Factura();
    $factura->user()->associate(Auth::user());
        // Alternativa:
        // $factura->user_id = Auth::id();
    $factura->save();

    $attachs = [];
    foreach ($carrito->getLineas() as $articulo_id => $linea) {
        $attachs[$articulo_id] = ['cantidad' => $linea->getCantidad()];
    }
    $factura->articulos()->attach($attachs);

        // Alternativa 1:
        // foreach ($carrito->getLineas() as $linea) {
        //     $factura->articulos()
        //         ->attach($linea->getArticulo(), [
        //             'cantidad' => $linea->getCantidad()
        //         ]);
        // }

        // Alternativa 2:
        // $inserts = [];
        // foreach ($carrito->getLineas() as $articulo_id => $linea) {
        //     $inserts[] = [
        //         'factura_id' => $factura->id,
        //         'articulo_id' => $articulo_id,
        //         'cantidad' => $linea->getCantidad(),
        //     ];
        // }
        // DB::table('articulo_factura')->insert($inserts);

    DB::commit();
    Mail::to($request->user())->send(new PedidoGenerado($factura));
    session()->flash('success', 'La factura se ha generado correctamente.');
    session()->forget('carrito');
    return redirect()->route('principal');
})->middleware('auth')->name('realizar_compra');

Route::resource('facturas', FacturaController::class);

require __DIR__.'/auth.php';
