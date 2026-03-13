<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\TunjanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DataKaryawan;
use Carbon\Carbon;
use App\Models\DataPresensi;
use App\Models\DataCutiKaryawan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk Halaman Depan 
Route::get('/', function () {
    return view('landing');
});

// Route untuk Halaman Form Login 
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Resource 
Route::resource('karyawan', KaryawanController::class);
Route::resource('presensi', PresensiController::class);
Route::resource('cuti', CutiController::class);
Route::resource('tunjangan', TunjanganController::class);

// Untuk Dashboard HRD
Route::get('/dashboard', function () {
    return view('hrd.dashboard-hrd'); 
})->name('dashboard');

// Untuk Dashboard Perawat
Route::get('/dashboard-perawat', function () {
    // Ambil data user/perawat yang sedang login saat ini
    $perawat = Auth::user(); 
    
    // Arahkan ke file view dan bawa datanya menggunakan compact()
    // Sesuaikan 'karyawan.dashboard-perawat' dengan nama folder dan file
    return view('karyawan.dashboard-perawat', compact('perawat')); 
})->name('dashboard.perawat');

Route::get('/dashboard-perawat', function () {
    $perawat = Auth::user(); 
    
    $pengumuman_rs = [
        "Jadwal shift perawat bulan April sudah rilis di grup.",
        "Pengajuan cuti maksimal tanggal 20 setiap bulan.",
        "Jangan lupa cuci tangan 6 langkah sebelum tindakan medis."
    ];
    
    // Kirim array tersebut ke tampilan (view)
    return view('karyawan.dashboard-perawat', compact('perawat', 'pengumuman_rs')); 
})->name('dashboard.perawat');

// Untuk Dashboard Keuangan
Route::get('/dashboard-keuangan', function () {
    $total_perawat = \App\Models\User::where('role', 'perawat')->count();
    
    $data_perawat = \App\Models\User::where('role', 'perawat')->get();
    
    return view('administrasi-keuangan-perawat.dashboard-admin', [
        'total_perawat' => $total_perawat,
        'data_perawat' => $data_perawat
    ]);
})->name('dashboard.keuangan');


// Rute untuk menampilkan halaman Form Tambah
Route::get('/hrd/tambah-karyawan', function () {
    return view('hrd.tambah-karyawan');
})->name('hrd.tambah-karyawanz');

// Rute untuk menyimpan data ke Database (Proses INSERT)
Route::post('/hrd/tambah-karyawan', function (Illuminate\Http\Request $request) {
    try {
        // Memasukkan data ke tabel users
        App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'perawat' 
        ]);

        return redirect('dashboard')->with('success', 'Data Perawat berhasil ditambahkan!');

    } catch (\Exception $e) {
        dd("GAGAL MENYIMPAN! Error dari database: " . $e->getMessage());
    }
})->name('hrd.tambah');

// Rute untuk MENAMPILKAN form Edit (Membawa data lama)
Route::get('/hrd/info-karyawan/data-karyawan{id}', function ($id) {
    // Cari data perawat berdasarkan ID yang diklik
    $karyawan = App\Models\User::findOrFail($id);
    
    // Buka halaman form edit
    return view('hrd.update-karyawan', compact('karyawan'));
})->name('hrd.updatez');

// Rute untuk MENYIMPAN perubahan data
Route::post('/hrd/update-karyawan/{id}', function (Illuminate\Http\Request $request, $id) {
    $karyawan = App\Models\User::findOrFail($id);

    // Update nama dan username
    $karyawan->name = $request->name;
    $karyawan->username = $request->username;

    // Update password HANYA jika HRD mengetikkan password baru
    // Kalau form password dikosongkan, password lama tetap aman
    if ($request->filled('password')) {
        $karyawan->password = Illuminate\Support\Facades\Hash::make($request->password);
    }

    $karyawan->save(); // Simpan perubahan

    // Kembalikan ke tabel dengan pesan sukses
    return redirect('dashboard')->with('success', 'Data Perawat berhasil diperbarui!');
})->name('hrd.update');

// Rute untuk MENGHAPUS data karyawan
Route::post('/hrd/info-karyawan/data-karyawan/{id}', function ($id) {
    // Cari data perawat berdasarkan ID
    $karyawan = App\Models\User::findOrFail($id);
    
    // Eksekusi perintah hapus dari database
    $karyawan->delete();

    // Kembalikan ke halaman tabel dengan pesan sukses
    return redirect('dashboard')->with('success', 'Data Perawat berhasil dihapus!');
})->name('hrd.deleted'); 

Route::get('/dashboard', function () {
    $karyawan_lengkap = \App\Models\DataKaryawan::all();
    $total_perawat = \App\Models\DataKaryawan::count(); 
    
    $hari_ini = \Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d');
    
    $hadir_hari_ini = \App\Models\DataPresensi::whereDate('tanggal', $hari_ini)->count();

    $izin_cuti = \App\Models\DataCutiKaryawan::where('status_persetujuan', 'Disetujui')
                ->where('tgl_mulai', '<=', $hari_ini)
                ->where('tgl_selesai', '>=', $hari_ini)
                ->count();

    $belum_absen = $total_perawat - ($hadir_hari_ini + $izin_cuti);
    if($belum_absen < 0) {
        $belum_absen = 0;
    }

    return view('hrd.dashboard-hrd', compact(
        'karyawan_lengkap', 'total_perawat', 'hadir_hari_ini', 'izin_cuti', 'belum_absen'
    ));
})->middleware('auth')->name('dashboard');

Route::post('/karyawan/dashboard-perawat', function() {
    $user = Auth::user();
    $hariIni = \Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d');
    $jamSekarang = \Carbon\Carbon::now('Asia/Makassar')->format('H:i:s');

    $sudahAbsen = \App\Models\DataPresensi::where('nik', $user->username)->where('tanggal', $hariIni)->first();

    if($sudahAbsen) {
        return back()->with('error', 'Anda sudah melakukan absen masuk hari ini!');
    }

    \App\Models\DataPresensi::create([
        'nik' => $user->username,
        'tanggal' => $hariIni,
        'jam_masuk' => $jamSekarang,
        'keterangan_shift' => 'Pagi'
    ]);

    return back()->with('success', 'Berhasil Catat Masuk! Selamat bertugas.');
})->name('presensi.masuk');


Route::post('/perawat/presensi/pulang', function() {
    $user = Auth::user();
    $hariIni = \Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d');
    $jamSekarang = \Carbon\Carbon::now('Asia/Makassar')->format('H:i:s');

    $absenHariIni = \App\Models\DataPresensi::where('nik', $user->username)->where('tanggal', $hariIni)->first();

    if(!$absenHariIni) return back()->with('error', 'Anda belum absen masuk hari ini!');
    if($absenHariIni->jam_keluar) return back()->with('error', 'Anda sudah melakukan absen pulang!');

    $absenHariIni->update(['jam_keluar' => $jamSekarang]);

    return back()->with('success', 'Berhasil Catat Pulang! Hati-hati di jalan.');
})->name('presensi.pulang');


Route::post('/perawat/presensi/pulang', function() {
    $user = Auth::user();
    $hariIni = Carbon::today()->toDateString();

    // Cari data absen hari ini milik perawat tersebut
    $absenHariIni = DataPresensi::where('nik', $user->username)->where('tanggal', $hariIni)->first();

    if(!$absenHariIni) {
        return back()->with('error', 'Anda belum absen masuk hari ini!');
    }

    if($absenHariIni->jam_keluar) {
         return back()->with('error', 'Anda sudah melakukan absen pulang!');
    }

    $absenHariIni->update([
        'jam_keluar' => Carbon::now()->toTimeString()
    ]);

    return back()->with('success', 'Berhasil Catat Pulang! Hati-hati di jalan.');
})->name('presensi.pulang');

// RUTE FORM TAMBAH BIODATA 
Route::get('/hrd/tambah-biodata', function () {
    $akun_users = App\Models\User::where('role', 'perawat')->get();
    return view('hrd.tambah-biodata', compact('akun_users'));
})->name('biodata.create');

Route::post('/hrd/tambah-biodata', function (Illuminate\Http\Request $request) {
    $jenisKelaminBaku = ($request->jenis_kelamin == 'Laki-laki' || $request->jenis_kelamin == 'L') ? 'L' : 'P';
    App\Models\DataKaryawan::create([
        'nik' => $request->nik,
        'id_login' => $request->id_login,
        'nama_lengkap' => $request->nama_lengkap,
        'jenis_kelamin' => $jenisKelaminBaku,
        'jabatan' => $request->jabatan,
        'status_karyawan' => $request->status_karyawan,
    ]);
    return redirect('dashboard')->with('success', 'Biodata Karyawan berhasil ditambahkan!');
})->name('biodata.store');


// RUTE HAPUS BIODATA 
Route::delete('/hrd/dashboard-hrd/{nik}', function ($nik) {
    $biodata = App\Models\DataKaryawan::where('nik', $nik)->firstOrFail();
    $biodata->delete(); 
    return redirect('dashboard')->with('success', 'Biodata Karyawan berhasil dihapus!');
})->name('biodata.delete');

// Tampilkan form edit (Mengambil data berdasarkan NIK)
Route::get('/hrd/edit-biodata/{nik}', function ($nik) {
    $karyawan = \App\Models\DataKaryawan::where('nik', $nik)->firstOrFail();
    return view('hrd.info-karyawan.edit-biodata', compact('karyawan'));
})->name('biodata.edit');

// Proses update data ke database
Route::put('/hrd/update-biodata/{nik}', function (Illuminate\Http\Request $request, $nik) {
    $karyawan = \App\Models\DataKaryawan::where('nik', $nik)->firstOrFail();
    
    // Pastikan jenis kelamin tetap L/P sesuai aturan database kamu
    $jenisKelaminBaku = ($request->jenis_kelamin == 'Laki-laki' || $request->jenis_kelamin == 'L') ? 'L' : 'P';

    $karyawan->update([
        'nama_lengkap' => $request->nama_lengkap,
        'jenis_kelamin' => $jenisKelaminBaku,
        'jabatan' => $request->jabatan,
        'status_karyawan' => $request->status_karyawan,
    ]);

    return redirect()->route('dashboard')->with('success', 'Biodata ' . $request->nama_lengkap . ' berhasil diperbarui!');
})->name('biodata.update');

// RUTE DASHBOARD PERAWAT
Route::get('/dashboard-perawat', function () {
    $perawat = Auth::user(); 
    
    // Ambil riwayat cuti dari database (Sesuai kolom id_cuti)
    $list_cuti = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                ->orderBy('id_cuti', 'desc')
                ->get();

    // Hitung Sisa Cuti (Hanya menghitung yang statusnya 'Disetujui')
    $cuti_approved = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                    ->where('status_persetujuan', 'Disetujui')
                    ->get();

    $total_hari_terpakai = 0;
    foreach($cuti_approved as $c) {
        $start = \Carbon\Carbon::parse($c->tgl_mulai);
        $end = \Carbon\Carbon::parse($c->tgl_selesai);
        $total_hari_terpakai += $start->diffInDays($end) + 1;
    }
    $sisa_cuti = 12 - $total_hari_terpakai;

    $pengumuman_rs = [
        "Jadwal shift perawat bulan April sudah rilis di grup.",
        "Pengajuan cuti maksimal tanggal 20 setiap bulan.",
        "Jangan lupa cuci tangan 6 langkah sebelum tindakan medis."
    ];
    
    return view('karyawan.dashboard-perawat', compact('perawat', 'pengumuman_rs', 'list_cuti', 'sisa_cuti')); 
})->name('dashboard.perawat');


// RUTE DASHBOARD PERAWAT 
Route::get('/dashboard-perawat', function () {
    $perawat = Auth::user(); 
    
    // Ambil riwayat cuti dari database (Sesuai kolom id_cuti)
    $list_cuti = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                ->orderBy('id_cuti', 'desc')
                ->get();

    // Hitung Sisa Cuti (Hanya menghitung yang statusnya 'Disetujui')
    $cuti_approved = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                    ->where('status_persetujuan', 'Disetujui')
                    ->get();

    $total_hari_terpakai = 0;
    foreach($cuti_approved as $c) {
        $start = \Carbon\Carbon::parse($c->tgl_mulai);
        $end = \Carbon\Carbon::parse($c->tgl_selesai);
        $total_hari_terpakai += $start->diffInDays($end) + 1;
    }
    $sisa_cuti = 12 - $total_hari_terpakai;

    $pengumuman_rs = [
        "Jadwal shift perawat bulan April sudah rilis di grup.",
        "Pengajuan cuti maksimal tanggal 20 setiap bulan.",
        "Jangan lupa cuci tangan 6 langkah sebelum tindakan medis."
    ];
    
    return view('karyawan.dashboard-perawat', compact('perawat', 'pengumuman_rs', 'list_cuti', 'sisa_cuti')); 
})->name('dashboard.perawat');


// RUTE DASHBOARD PERAWAT
Route::get('/dashboard-perawat', function () {
    $perawat = Auth::user(); 
    
    // Ambil riwayat cuti dari database (Sesuai kolom id_cuti)
    $list_cuti = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                ->orderBy('id_cuti', 'desc')
                ->get();

    // Hitung Sisa Cuti (Hanya menghitung yang statusnya 'Disetujui')
    $cuti_approved = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                    ->where('status_persetujuan', 'Disetujui')
                    ->get();

    $total_hari_terpakai = 0;
    foreach($cuti_approved as $c) {
        $start = \Carbon\Carbon::parse($c->tgl_mulai);
        $end = \Carbon\Carbon::parse($c->tgl_selesai);
        $total_hari_terpakai += $start->diffInDays($end) + 1;
    }
    $sisa_cuti = 12 - $total_hari_terpakai;

    $pengumuman_rs = [
        "Jadwal shift perawat bulan April sudah rilis di grup.",
        "Pengajuan cuti maksimal tanggal 20 setiap bulan.",
        "Jangan lupa cuci tangan 6 langkah sebelum tindakan medis."
    ];
    
    return view('karyawan.dashboard-perawat', compact('perawat', 'pengumuman_rs', 'list_cuti', 'sisa_cuti')); 
})->name('dashboard.perawat');


// RUTE DASHBOARD PERAWAT
Route::get('/dashboard-perawat', function () {
    $perawat = Auth::user(); 
    
    // Ambil riwayat cuti dari database (Sesuai kolom id_cuti)
    $list_cuti = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                ->orderBy('id_cuti', 'desc')
                ->get();

    // Hitung Sisa Cuti (Hanya menghitung yang statusnya 'Disetujui')
    $cuti_approved = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)
                    ->where('status_persetujuan', 'Disetujui')
                    ->get();

    $total_hari_terpakai = 0;
    foreach($cuti_approved as $c) {
        $start = \Carbon\Carbon::parse($c->tgl_mulai);
        $end = \Carbon\Carbon::parse($c->tgl_selesai);
        $total_hari_terpakai += $start->diffInDays($end) + 1;
    }
    $sisa_cuti = 12 - $total_hari_terpakai;

    $pengumuman_rs = [
        "Jadwal shift perawat bulan April sudah rilis di grup.",
        "Pengajuan cuti maksimal tanggal 20 setiap bulan.",
        "Jangan lupa cuci tangan 6 langkah sebelum tindakan medis."
    ];
    
    return view('karyawan.dashboard-perawat', compact('perawat', 'pengumuman_rs', 'list_cuti', 'sisa_cuti')); 
})->name('dashboard.perawat');


// RUTE SIMPAN CUTI
Route::post('/cuti/simpan', function (Illuminate\Http\Request $request) {
    // Validasi input
    $request->validate([
        'tgl_mulai' => 'required|date',
        'tgl_selesai' => 'required|date',
        'alasan_cuti' => 'required|string',
    ]);

    // Simpan ke tabel data_cuti_karyawan SESUAI NAMA KOLOM DI DATABASE
    \App\Models\DataCutiKaryawan::create([
        'nik' => Auth::user()->username, 
        'tgl_pengajuan' => \Carbon\Carbon::today(), 
        'tgl_mulai' => $request->tgl_mulai,
        'tgl_selesai' => $request->tgl_selesai,
        'alasan_cuti' => $request->alasan_cuti,
        'status_persetujuan' => 'Menunggu' 
    ]);

    return back()->with('success', 'Pengajuan cuti berhasil terkirim!');
})->name('cuti.simpan');

// 1. Menampilkan Halaman Persetujuan Cuti 
Route::get('/administrasi/kelola-cuti', function () {
    // Ambil semua data cuti, urutkan dari yang terbaru (tgl_pengajuan)
    $semua_cuti = \App\Models\DataCutiKaryawan::orderBy('tgl_pengajuan', 'desc')->get();
    
    return view('hrd.kelola-cuti', compact('semua_cuti')); 
})->name('admin.cuti.index');

// Proses Update Status Cuti 
Route::put('/administrasi/cuti/update/{id_cuti}', function (Illuminate\Http\Request $request, $id_cuti) {
    // Cari data cuti berdasarkan id_cuti
    $cuti = \App\Models\DataCutiKaryawan::findOrFail($id_cuti);
    
    // Update kolom status_persetujuan
    $cuti->update([
        'status_persetujuan' => $request->status_persetujuan
    ]);

    return back()->with('success', 'Status cuti berhasil diubah menjadi: ' . $request->status_persetujuan);
})->name('admin.cuti.update');

// Rute untuk mengeksekusi tombol Setujui/Tolak
Route::put('/administrasi/cuti/update/{id_cuti}', function (Illuminate\Http\Request $request, $id_cuti) {
    $cuti = \App\Models\DataCutiKaryawan::findOrFail($id_cuti);
    $cuti->update(['status_persetujuan' => $request->status_persetujuan]);

    return back()->with('success', 'Status cuti berhasil diubah menjadi: ' . $request->status_persetujuan);
})->name('admin.cuti.update');

Route::put('/administrasi/cuti/update/{id_cuti}', function (Illuminate\Http\Request $request, $id_cuti) {
    $cuti = \App\Models\DataCutiKaryawan::findOrFail($id_cuti);
    $cuti->update(['status_persetujuan' => $request->status_persetujuan]);
    return back()->with('success', 'Keputusan cuti berhasil disimpan!');
})->name('admin.cuti.update');

// Rute untuk memproses form pengiriman tunjangan
Route::post('/tunjangan/simpan', function (Illuminate\Http\Request $request) {
    $request->validate([
        'nik' => 'required',
        'periode_bulan' => 'required',
        'nominal_dasar' => 'required|numeric',
    ]);

    $tambahan = $request->tunjangan_tambahan ?? 0; 
    $total_tunjangan = $request->nominal_dasar + $tambahan;

    DataTunjanganKaryawan::create([
        'nik' => $request->nik,
        'periode_bulan' => $request->periode_bulan,
        'nominal_dasar' => $request->nominal_dasar,
        'total_tunjangan' => $total_tunjangan
    ]);

    return back()->with('success', 'Nominal tunjangan berhasil dikirim ke perawat!');
})->name('tunjangan.simpan');