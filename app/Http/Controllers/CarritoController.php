<?php

namespace App\Http\Controllers;

use App\Generico\Carrito;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarritoController extends Controller
{
    public function insertar($id)
    {
        Articulo::findOrFail($id);
        $carrito = Carrito::carrito();
        $carrito->insertar($id);
        session()->put('carrito', $carrito);
        return redirect()->route('principal');
    }

    public function eliminar($id)
    {
        Articulo::findOrFail($id);
        $carrito = Carrito::carrito();
        $carrito->eliminar($id);
        session()->put('carrito', $carrito);
        return redirect()->route('principal');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('principal');
    }
}
