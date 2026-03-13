<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLogin extends Model
{
    use HasFactory;

    protected $table = 'data_login';
    protected $primaryKey = 'id_login';
    protected $guarded = []; //izinkan semua kolom diisi secara massal

    //1-to-1 ke karyawan
    public function karyawan()
    {
        return $this->hasOne(DataKaryawan::class, 'id_login', 'id_login');
    }
}