<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('customer', function (Blueprint $table) {

            $table->id('idcustomer');

            $table->string('nama');
            $table->text('alamat');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kodepos');

            // untuk menyimpan foto dari kamera (base64)
            $table->longText('foto_blob')->nullable();

            // untuk metode penyimpanan file
            $table->string('foto_path')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('customer');
    }

};