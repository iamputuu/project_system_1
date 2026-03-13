<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_login', function (Blueprint $table) {
            $table->id('id_login');
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['HR', 'Keuangan', 'Perawat']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_login');
    }
};
