<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Biodata Karyawan - HRD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-4 text-center text-primary">Isi Biodata Karyawan</h4>
                
                <form action="{{ route('biodata.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Akun Login (id_login)</label>
                        <select name="id_login" class="form-select" required>
                            <option value="">-- Pilih Akun User --</option>
                            @foreach($akun_users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->name }})</option>
                            @endforeach
                        </select>
                        <div class="form-text">Pastikan akun user sudah dibuat sebelumnya.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nomor Induk Karyawan (NIK)</label>
                        <input type="text" name="nik" class="form-control" placeholder="Contoh: PRW202600" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Jabatan</label>
                           <select name="jabatan" class="form-select" required>
    <option value="">-- Pilih Jabatan --</option>
    <option value="Perawat Terampil">Perawat Terampil</option>
    <option value="Perawat Mahir">Perawat Mahir</option>
    </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Status</label>
                            <select name="status_karyawan" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Resign">Resign</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Biodata</button>
                        <a href="/hr/data-karyawan" class="btn btn-light">Batal & Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>