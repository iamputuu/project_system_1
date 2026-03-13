<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Mcp\Enums\Role;

class AuthController extends Controller
{
    public function index()
    {
        return view('login'); //login.blade.php
    }

    public function login(Request $request)
    {
        // 1. Validasi inputan
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. Cek ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 3. Arahkan ke dashboard sesuai jabatan (Role)
            $role = Auth::user()->role;
            
            if ($role === 'hrd') {
                return redirect()->route('dashboard'); // Ke Dashboard HRD
            } elseif ($role === 'keuangan') {
                return redirect()->route('dashboard.keuangan'); // Ke Dashboard Keuangan
            } elseif ($role === 'perawat') {
                return redirect()->route('dashboard.perawat'); // Ke Dashboard Perawat
            } else {
                return redirect('/'); // Jaga-jaga jika role tidak ada
            }
        } // <-- Batas akhir pengecekan login sukses

        // 4. Jika password salah, kembalikan ke halaman login bawa pesan error
        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}