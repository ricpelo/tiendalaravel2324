<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Interfaces\ImageInterface;

class Articulo extends Model
{
    use HasFactory;

    const MIME_IMAGEN = 'jpg';

    private function imagen_url_relativa()
    {
        return '/uploads/' . $this->imagen;
    }

    private function miniatura_url_relativa()
    {
        return '/uploads/' . $this->miniatura;
    }

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

    public function facturas()
    {
        return $this->belongsToMany(Factura::class)->withPivot('cantidad');
    }

    public function getImagenAttribute()
    {
        return $this->id . '.' . self::MIME_IMAGEN;
    }

    public function getMiniaturaAttribute()
    {
        return $this->id . '_mini.' . self::MIME_IMAGEN;
    }

    public function getImagenUrlAttribute()
    {
        return Storage::url(mb_substr($this->imagen_url_relativa(), 1));
    }

    public function getMiniaturaUrlAttribute()
    {
        return Storage::url(mb_substr($this->miniatura_url_relativa(), 1));
    }

    public function existeImagen()
    {
        return Storage::disk('public')->exists($this->imagen_url_relativa());
    }

    public function existeMiniatura()
    {
        return Storage::disk('public')->exists($this->miniatura_url_relativa());
    }

    public function guardarImagen(UploadedFile $imagen, string $nombre, int $escala, ?ImageManager $manager = null)
    {
        if ($manager === null) {
            $manager = new ImageManager(new Driver());
        }

        $imagen = $manager->read($imagen);
        $imagen->scaleDown($escala);
        $ruta = Storage::path('public/uploads/' . $nombre);
        $imagen->save($ruta);
    }
}
