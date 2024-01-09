<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Factura::class, 'factura');
    }

    public function show(Factura $factura)
    {
        foreach ($factura->articulos as $articulo) {
            echo $articulo->denominacion . '<br/>';
        }
    }
}
