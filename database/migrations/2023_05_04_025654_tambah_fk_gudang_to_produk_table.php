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
        Schema::table('produk', function (Blueprint $table) {
            //
            $table->unsignedInteger('id_gudang')->change();
            $table->foreign('id_gudang')
                  ->references('id_gudang')
                  ->on('gudang')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            //
            $table->integer('id_gudang')->change();
            $table->dropForeign('produk_id_gudang_foreign');
        });
    }
};
