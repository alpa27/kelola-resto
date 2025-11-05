<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaksi extends Model
{
    protected $primaryKey = 'idtransaksi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idtransaksi',
        'idpesanan',
        'total',
        'bayar',
    ];

    protected $casts = [
        'total' => 'integer',
        'bayar' => 'integer',
    ];

    /**
     * Get the pesanan that owns the transaksi.
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }

    /**
     * Pesanan items linked to this transaksi (pivot support for multiple items).
     */
    public function pesanans(): BelongsToMany
    {
        return $this->belongsToMany(Pesanan::class, 'transaksi_pesanan', 'idtransaksi', 'idpesanan');
    }
}
