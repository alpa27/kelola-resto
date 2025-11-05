<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pesanan extends Model
{
    protected $primaryKey = 'idpesanan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idpesanan',
        'order_code',
        'idmenu',
        'idpelanggan',
        'idmeja',
        'jumlah',
        'iduser',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    /**
     * Get the menu that owns the pesanan.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'idmenu');
    }

    /**
     * Get the pelanggan that owns the pesanan.
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan');
    }

    /**
     * Get the user that owns the pesanan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    /**
     * Get the transaksi for the pesanan.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'idpesanan');
    }

    /**
     * Transaksi (pivot) yang terkait dengan pesanan ini.
     */
    public function transaksis(): BelongsToMany
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_pesanan', 'idpesanan', 'idtransaksi');
    }

    /**
     * Get the meja that owns the pesanan.
     */
    public function meja(): BelongsTo
    {
        return $this->belongsTo(Meja::class, 'idmeja');
    }
}
