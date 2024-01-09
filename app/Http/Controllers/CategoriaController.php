<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoriaController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Categoria::class, 'categoria');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categorias.index', [
            'categorias' => Categoria::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        // $this->authorize('update');

        $validated = $request->validated();
        $categoria = new Categoria();
        $categoria->nombre = $validated['nombre'];
        $categoria->save();
        session()->flash('success', 'La categoría se ha creado correctamente.');
        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return 'Hola, soy el Show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        // $this->authorize('update', $categoria);

        $validated = $request->validated();
        $categoria->nombre = $validated['nombre'];
        $categoria->save();
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->articulos->isEmpty()) {
            $categoria->delete();
        } else {
            session()->flash('error', 'La categoría tiene artículos.');
        }
        return redirect()->route('categorias.index');
    }
}
