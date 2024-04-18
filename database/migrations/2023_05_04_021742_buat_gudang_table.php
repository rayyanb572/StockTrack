<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('gudang', function (Blueprint $table) {
            $table->increments('id_gudang');
            $table->string('nama_gudang')->unique();
            $table->string('alamat_gudang');
            $table->integer('ukuran_gudang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang');
        //
    }
};
