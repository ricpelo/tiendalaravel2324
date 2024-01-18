<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Iva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $request->query('order', 'denominacion');
        $order_dir = $request->query('order_dir', 'asc');
        $articulos = Articulo::with(['iva', 'categoria'])
            ->selectRaw('articulos.*')
            ->leftJoin('categorias', 'articulos.categoria_id', '=', 'categorias.id')
            ->leftJoin('ivas', 'articulos.iva_id', '=', 'ivas.id')
            ->orderBy($order, $order_dir)
            ->orderBy('denominacion')
            ->paginate(3);
        return view('articulos.index', [
            'articulos' => $articulos,
            'order' => $order,
            'order_dir' => $order_dir,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articulos.create', [
            'categorias' => Categoria::all(),
            'ivas' => Iva::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validar($request);
        Articulo::create($validated);
        return redirect()->route('articulos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show', [
            'articulo' => $articulo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', [
            'articulo' => $articulo,
            'categorias' => Categoria::all(),
            'ivas' => Iva::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Articulo $articulo)
    {
        $validated = $this->validar($request);
        $articulo->update($validated);
        return redirect()->route('articulos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
        return redirect()->route('articulos.index');
    }

    private function validar(Request $request)
    {
        return $request->validate([
            'denominacion' => 'required|max:255',
            'precio' => 'required|numeric|decimal:2|between:-9999.99,9999.99',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'iva_id' => 'required|integer|exists:ivas,id'
        ]);
    }

    public function cambiar_imagen(Articulo $articulo)
    {
        return view('articulos.cambiar_imagen', [
            'articulo' => $articulo,
        ]);
    }

    public function guardar_imagen(Articulo $articulo, Request $request)
    {
        $mime = Articulo::MIME_IMAGEN;

        $request->validate([
            'imagen' => "required|mimes:$mime|max:500",
        ]);

        $imagen = $request->file('imagen');
        Storage::makeDirectory('public/uploads');
        // $imagen->storeAs('uploads', $nombre, 'public');

        $imagen_original = $imagen;
        $manager = new ImageManager(new Driver());
        $articulo->guardarImagen($imagen, $articulo->imagen, 400, $manager);
        $imagen = $imagen_original;
        $articulo->guardarImagen($imagen, $articulo->miniatura, 200, $manager);
        return redirect()->route('articulos.index');
    }
}
