<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Perawat - HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
        }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .form-control {
            border-radius: 0 8px 8px 0;
            padding: 12px 15px;
            background-color: #f8f9fa;
        }
        .input-group-text {
            border-radius: 8px 0 0 8px;
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control:focus {
            border-color: #0071e3;
            box-shadow: none;
            background-color: #fff;
        }
        .form-control:focus + .input-group-text {
            background-color: #fff;
            border-color: #0071e3;
        }
        .btn-primary-custom {
            background-color: #0071e3;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #005bb5;
            transform: translateY(-2px);
        }
        .btn-light-custom {
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            background-color: #e9ecef;
            border: none;
            transition: 0.3s;
        }
        .btn-light-custom:hover {
            background-color: #dde0e3;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="card card-custom p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Tambah Perawat Baru</h4>
                        <p class="text-muted small">Masukkan data diri dan akses login perawat.</p>
                    </div>

                    <form action="{{ route('hrd.tambah') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Nama Lengkap & Gelar</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Contoh: Putu Gede, S.Kep" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small">Username Login (Gunakan NIK)</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-card-text text-muted"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Contoh: PRW2026002" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small">Password Awal</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Minimal 6 karakter" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom text-white">Simpan Data Perawat</button>
                            <a href="{{ route('hrd.tambah') }}" class="btn btn-light-custom text-muted">Batal & Kembali</a>
                        </div>
                    </form>
                    </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>