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
        Schema::create('kecelakaans', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('bulan', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
            $table->integer('tahun');
            $table->integer('r2');
            $table->integer('r4');
            $table->integer('r6');
            $table->integer('rugi_materi');
            $table->integer('meninggal_dunia');
            $table->integer('luka_berat');
            $table->integer('luka_ringan');
            $table->integer('jumlah_kecelakaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecelakaans');
    }
};
