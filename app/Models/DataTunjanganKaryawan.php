<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTunjanganKaryawan extends Model
{
    use HasFactory;
    protected $table = 'data_tunjangan_karyawan';
    protected $primaryKey = 'id_tunjangan';
    protected $guarded = []; // Ini WAJIB agar data bisa masuk!

    //balik ke karyawan
    public function karyawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nik', 'nik');
    }
}