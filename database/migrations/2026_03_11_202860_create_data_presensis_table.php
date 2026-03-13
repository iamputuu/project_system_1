<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('data_presensi', function (Blueprint $table) {
            $table->id('id_presensi');
            
            //tabel data_karyawan
            $table->string('nik', 20);
            $table->foreign('nik')->references('nik')->on('data_karyawan')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('keterangan_shift', ['Pagi', 'Siang', 'Malam']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_presensi');
    }
};
