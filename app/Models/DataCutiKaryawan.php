<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCutiKaryawan extends Model
{
    use HasFactory;

    protected $table = 'data_cuti_karyawan';
    protected $primaryKey = 'id_cuti';
    protected $guarded = [];

    //relasi balik ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nik', 'nik');
    }
}