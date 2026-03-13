<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan Model User dipanggil

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun HRD
        User::create([
            'name' => 'Admin HRD Utama',
            'username' => 'adminhrd',
            'password' => bcrypt('hrd123'), // Kita samakan jadi hrd123 agar mudah diingat
            'role' => 'hrd'
        ]);

        // 2. Akun Administrasi & Keuangan
        User::create([
            'name' => 'Ibu Finance',
            'username' => 'adminkeuangan',
            'password' => bcrypt('keuangan123'),
            'role' => 'keuangan'
        ]);

        // 3. Akun Perawat Biasa
        User::create([
            'name' => 'Ni Wayan Sari, S.Kep',
            'username' => 'PRW2026001',
            'password' => bcrypt('perawat123'),
            'role' => 'perawat'
        ]);
    }
}