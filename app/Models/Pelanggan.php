<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $primaryKey = 'idpelanggan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idpelanggan',
        'namapelanggan',
        'jeniskelamin',
        'nohp',
        'alamat',
    ];

    protected $casts = [
        'jeniskelamin' => 'boolean',
    ];

    /**
     * Get the pesanan for the pelanggan.
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'idpelanggan');
    }
}
