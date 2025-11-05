<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pesanan', function (Blueprint $table) {
            $table->string('idtransaksi');
            $table->string('idpesanan');
            $table->primary(['idtransaksi', 'idpesanan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pesanan');
    }
};


