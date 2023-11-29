<?php

namespace App\Generico;

use App\Models\Articulo;

class Linea
{
    private Articulo $articulo;
    private int $cantidad;

    public function __construct(Articulo $articulo, int $cantidad = 1)
    {
        $this->articulo = $articulo;
        $this->cantidad = $cantidad;
    }

    public function getArticulo(): Articulo
    {
        return $this->articulo;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function incrCantidad()
    {
        $this->cantidad++;
    }

    public function decrCantidad()
    {
        $this->cantidad--;
    }
}
