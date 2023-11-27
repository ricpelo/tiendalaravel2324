<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articulo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['denominacion', 'precio', 'categoria_id', 'iva_id'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function iva(): BelongsTo
    {
        return $this->belongsTo(Iva::class);
    }

    public function getPrecioIiAttribute()
    {
        return $this->precio * (1 + $this->iva->por / 100);
    }
}
