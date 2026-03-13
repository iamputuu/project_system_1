<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        //get data karyawan perawat
        $data_perawat = User::where('role', 'perawat')->get();

        //perlihatkan ke halaman presensi
        return view('hrd.info-karyawan.presensi-karyawan', compact('data_perawat'));

            // Ambil tanggal hari ini versi WITA
        $hari_ini = \Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d');
        $tanggal_tampil = \Carbon\Carbon::now('Asia/Makassar')->format('d F Y');

        // Ambil semua karyawan perawat
        $semua_perawat = \App\Models\DataKaryawan::all();

        // Ambil data presensi khusus hari ini
        $absen_hari_ini = \App\Models\DataPresensi::where('tanggal', $hari_ini)->get();

        return view('hrd.info-karyawan.presensi-karyawan', compact('semua_perawat', 'absen_hari_ini', 'tanggal_tampil'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
