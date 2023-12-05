<?php

use App\Generico\Carrito;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use App\Models\Articulo;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;
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
    $carrito = Carrito::carrito();
    $carrito->insertar($id);
    session()->put('carrito', $carrito);
    return redirect()->route('principal');
})->name('carrito.insertar')->whereNumber('id');

Route::get('/carrito/vaciar', function () {
    session()->forget('carrito');
    return redirect()->route('principal');
})->name('carrito.vaciar');

Route::get('/comprar', function () {
    return view('comprar', [
        'carrito' => carrito(),
    ]);
})->middleware('auth')->name('comprar');

Route::post('/realizar_compra', function () {
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
    session()->flash('success', 'La factura se ha generado correctamente.');
    session()->forget('carrito');
    return redirect()->route('principal');
})->middleware('auth')->name('realizar_compra');

Route::get('facturas', function () {
    // $u->facturas()->selectRaw('facturas.id, sum(cantidad * precio) as total')->join('articulo_factura', 'facturas.id', '=', 'articulo_factura.factura_id')->join('articulos', 'articulos.id', '=', 'articulo_factura.articulo_id')->groupBy('facturas.id')->get()
    return view('facturas', [
        'facturas' => Auth::user()->facturas,
    ]);
})->middleware('auth')->name('facturas.index');

require __DIR__.'/auth.php';
