<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'descripcion_corta',
        'precio',
        'precio_oferta',
        'stock',
        'sku',
        'imagen_principal',
        'material',
        'color',
        'dimensiones',
        'peso',
        'categoria_id',
        'proveedor_id',
        'destacado',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'precio_oferta' => 'decimal:2',
        'peso' => 'decimal:2',
        'destacado' => 'boolean',
        'activo' => 'boolean',
    ];

    /**
     * Generar slug automáticamente al crear.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            if (empty($producto->slug)) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });
    }

    /**
     * Obtener la categoría del producto.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Obtener el proveedor del producto.
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Obtener las imágenes del producto.
     */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id')->orderBy('orden');
    }

    /**
     * Obtener los detalles de pedido asociados.
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'producto_id');
    }

    /**
     * Scope para productos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para productos destacados.
     */
    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    /**
     * Scope para productos en oferta.
     */
    public function scopeEnOferta($query)
    {
        return $query->whereNotNull('precio_oferta')->where('precio_oferta', '>', 0);
    }

    /**
     * Obtener el precio final (oferta o normal).
     */
    public function getPrecioFinalAttribute(): float
    {
        return $this->precio_oferta && $this->precio_oferta > 0
            ? (float) $this->precio_oferta
            : (float) $this->precio;
    }

    /**
     * Verificar si tiene descuento.
     */
    public function getTieneDescuentoAttribute(): bool
    {
        return $this->precio_oferta && $this->precio_oferta > 0 && $this->precio_oferta < $this->precio;
    }

    /**
     * Obtener el porcentaje de descuento.
     */
    public function getPorcentajeDescuentoAttribute(): int
    {
        if (!$this->tiene_descuento) {
            return 0;
        }
        return (int) round((($this->precio - $this->precio_oferta) / $this->precio) * 100);
    }
}
