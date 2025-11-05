<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $primaryKey = 'idmenu';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'idmenu',
        'namamenu',
        'harga',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];

    /**
     * Get the pesanan for the menu.
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'idmenu');
    }
}
 