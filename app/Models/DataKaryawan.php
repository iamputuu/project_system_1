<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    use HasFactory;
    protected $table = 'data_karyawan';
    protected $primaryKey = 'nik'; // Kita set NIK sebagai kunci utamanya
    public $incrementing = false; // Karena NIK itu huruf/angka (varchar), bukan angka otomatis
    protected $keyType = 'string';

    protected $fillable = ['nik', 'id_login', 'nama_lengkap', 'jenis_kelamin', 'jabatan', 'status_karyawan'];
}