<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Perawat - HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: -apple-system, sans-serif; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .form-control { border-radius: 0 8px 8px 0; padding: 12px 15px; }
        .input-group-text { border-radius: 8px 0 0 8px; background-color: #f8f9fa; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-pencil-square fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Edit Data Perawat</h4>
                        <p class="text-muted small">Perbarui informasi akun sistem karyawan.</p>
                    </div>

                    <form action="{{ route('hrd.update', $karyawan->id) }}" method="POST">
                        @csrf 
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Nama Lengkap & Gelar</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0" value="{{ $karyawan->name }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Username Login (NIK)</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-card-text text-muted"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0" value="{{ $karyawan->username }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small">Ganti Password (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Kosongkan jika tidak ingin ganti sandi">
                            </div>
                            <small class="text-muted" style="font-size: 0.8rem;">*Hanya isi jika perawat lupa sandi atau ingin direset.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-bold text-dark">Simpan Perubahan</button>
                            <a href="/dashboard" class="btn btn-light text-muted fw-bold">Batal & Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>