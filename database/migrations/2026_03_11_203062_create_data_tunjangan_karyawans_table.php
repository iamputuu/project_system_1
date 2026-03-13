<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_tunjangan_karyawan', function (Blueprint $table) {
            $table->id('id_tunjangan');
            
            //ke tabel data_karyawan
            $table->string('nik', 20);
            $table->foreign('nik')->references('nik')->on('data_karyawan')->onDelete('cascade');
            
            $table->string('periode_bulan', 20);
            $table->integer('nominal_dasar');
            $table->integer('total_tunjangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_tunjangan_karyawan');
    }
};
