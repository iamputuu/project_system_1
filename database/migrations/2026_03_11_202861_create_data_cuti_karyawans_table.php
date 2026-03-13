<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('data_cuti_karyawan', function (Blueprint $table) {
            $table->id('id_cuti');
            
            //tabel data_karyawan
            $table->string('nik', 20);
            $table->foreign('nik')->references('nik')->on('data_karyawan')->onDelete('cascade');
            
            $table->date('tgl_pengajuan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->text('alasan_cuti');
            $table->enum('status_persetujuan', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_cuti_karyawan');
    }
};
