<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'folio',
        'pedido_id',
        'cliente_id',
        'user_id',
        'subtotal',
        'iva',
        'descuento',
        'total',
        'metodo_pago',
        'estado_pago',
        'notas',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Generar folio automáticamente.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($venta) {
            if (empty($venta->folio)) {
                $venta->folio = 'VTA-' . date('Ymd') . '-' . str_pad(
                    static::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Obtener el pedido asociado.
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    /**
     * Obtener el cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Obtener el vendedor.
     */
    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope para ventas pagadas.
     */
    public function scopePagadas($query)
    {
        return $query->where('estado_pago', 'pagado');
    }

    /**
     * Scope para ventas del día.
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('created_at', today());
    }
}
