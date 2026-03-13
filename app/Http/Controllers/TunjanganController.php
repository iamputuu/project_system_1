<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTunjanganKaryawan;

class TunjanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // (Opsional) Nanti bisa diisi untuk menampilkan tabel daftar tunjangan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari Modal Tunjangan
        $request->validate([
            'nik' => 'required',
            'periode_bulan' => 'required',
            'nominal_dasar' => 'required|numeric',
            'tunjangan_tambahan' => 'nullable|numeric' // Mengizinkan kosong, tapi kalau diisi harus angka
        ]);

        // 2. Hitung Total Tunjangan
        // Jika tunjangan_tambahan kosong, kita anggap 0
        $tambahan = $request->tunjangan_tambahan ?? 0;
        $total_tunjangan = $request->nominal_dasar + $tambahan;

        // 3. Simpan ke tabel data_tunjangan_karyawan
       DataTunjanganKaryawan::create([
    'nik' => $request->nik,
    'periode_bulan' => $request->periode_bulan,
    'nominal_dasar' => $request->nominal_dasar,
    'total_tunjangan' => $total_tunjangan
]);

        // 4. Kembalikan Admin ke halaman sebelumnya (dashboard) dengan pesan sukses
        return back()->with('success', 'Nominal tunjangan untuk NIK ' . $request->nik . ' berhasil dikirim!');
    }
}