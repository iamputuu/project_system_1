<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPresensi extends Model
{
    use HasFactory;

    // Beri tahu nama tabel yang benar sesuai di database-mu
    protected $table = 'data_presensi';
    protected $primaryKey = 'id_presensi';

    // Kolom yang boleh diisi
    protected $fillable = [
        'nik', 
        'tanggal', 
        'jam_masuk', 
        'jam_keluar', 
        'keterangan_shift'
    ];
}