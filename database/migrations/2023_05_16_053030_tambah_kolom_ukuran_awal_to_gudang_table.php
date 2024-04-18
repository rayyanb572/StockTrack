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
        Schema::table('gudang', function (Blueprint $table) {
            $table->integer('ukuran_awal')->nullable()->after('ukuran_gudang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudang', function (Blueprint $table) {
            $table->dropColumn('ukuran_awal');
        });
    }
};
