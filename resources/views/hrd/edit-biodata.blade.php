<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Biodata - {{ $karyawan->nama_lengkap }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">Edit Biodata Karyawan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('biodata.update', $karyawan->nik) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">NIK (ID Utama)</label>
                            <input type="text" class="form-control bg-light" value="{{ $karyawan->nik }}" readonly>
                            <small class="text-muted text-danger">*NIK tidak dapat diubah karena kunci utama.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $karyawan->nama_lengkap }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <select name="jabatan" class="form-select" required>
                                <option value="Perawat Terampil" {{ $karyawan->jabatan == 'Perawat Terampil' ? 'selected' : '' }}>Perawat Terampil</option>
                                <option value="Perawat Mahir" {{ $karyawan->jabatan == 'Perawat Mahir' ? 'selected' : '' }}>Perawat Mahir</option>
                                <option value="Perawat Penyelia" {{ $karyawan->jabatan == 'Perawat Penyelia' ? 'selected' : '' }}>Perawat Penyelia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Karyawan</label>
                            <select name="status_karyawan" class="form-select" required>
                                <option value="Aktif" {{ $karyawan->status_karyawan == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Resign" {{ $karyawan->status_karyawan == 'Resign' ? 'selected' : '' }}>Resign</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>