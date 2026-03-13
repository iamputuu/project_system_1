<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_karyawan', function (Blueprint $table) {
            $table->string('nik', 20)->primary();
            
            //ke tabel data_login
            $table->unsignedBigInteger('id_login')->unique();
            $table->foreign('id_login')->references('id_login')->on('data_login')->onDelete('cascade');
            
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('jabatan', [
                'Perawat Terampil', 'Perawat Mahir', 'Perawat Penyelia', 
                'Perawat Ahli Pertama', 'Perawat Ahli Muda', 
                'Perawat Ahli Madya', 'Perawat Ahli Utama'
            ]);
            $table->enum('status_karyawan', ['Aktif', 'Resign']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_karyawan');
    }
};
