<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Obtener los productos de esta categoría.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    /**
     * Scope para categorías activas.
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Obtener la URL de la imagen (soporta URLs externas como Baserow).
     */
    public function getImagenUrlAttribute(): string
    {
        if (empty($this->imagen)) {
            return asset('images/placeholder.jpg'); // Ajusta a una imagen por defecto si existe
        }
        
        if (\Illuminate\Support\Str::startsWith($this->imagen, ['http://', 'https://'])) {
            return $this->imagen;
        }

        return asset('storage/' . $this->imagen);
    }
}
