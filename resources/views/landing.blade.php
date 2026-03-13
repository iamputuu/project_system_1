<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Karyawan Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #fbfbfd;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .apple-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .apple-logo {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1d1d1f;
            text-decoration: none;
        }
        
        .hero {
            text-align: center;
            margin-top: 140px;
            padding: 0 20px;
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #1d1d1f;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.3rem;
            color: #86868b;
            margin-bottom: 40px;
        }

        .btn-main-login {
            display: inline-block;
            background-color: #0071e3;
            color: white;
            border-radius: 25px;
            padding: 12px 35px;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 113, 227, 0.3);
        }
        .btn-main-login:hover {
            background-color: #0077ed;
            color: white;
            transform: translateY(-2px);
        }

        .cards-container {
            margin-top: 80px;
            padding-bottom: 80px;
        }
        .role-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            padding: 50px 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid #f0f0f0;
            transition: transform 0.3s ease;
        }
        .role-card:hover {
            transform: translateY(-10px);
        }
        
        .role-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 25px;
        }
        .icon-hrd { background: linear-gradient(135deg, #0071e3 0%, #4facfe 100%); } /* Biru */
        .icon-admin { background: linear-gradient(135deg, #198754 0%, #38f9d7 100%); } /* Hijau */
        .icon-nurse { background: linear-gradient(135deg, #f56036 0%, #ff9a44 100%); } /* Oranye/Merah */

        .role-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1d1d1f;
            margin-bottom: 15px;
        }
        .role-desc {
            font-size: 1rem;
            color: #86868b;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<header class="apple-header">
    <a href="#" class="apple-logo"><i class="bi bi-heart-pulse-fill text-danger me-1"></i> Sistem RS</a>
</header>

<div class="hero">
    <h1>Satu sistem terpadu.<br>Tiga akses berbeda.</h1>
    <p>Kelola data karyawan, persetujuan cuti, distribusi gaji, hingga<br>absensi harian dalam satu platform yang mulus.</p>
    
    <a href="{{ route('login') }}" class="btn-main-login">
        Masuk ke Portal
    </a>
</div>

<div class="container cards-container">
    <div class="row g-4 justify-content-center">
        
        <div class="col-md-4">
            <div class="role-card border-top border-primary border-4">
                <div class="role-icon icon-hrd shadow-sm">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="role-title">Dashboard HRD</div>
                <div class="role-desc">Pusat kendali utama untuk mengelola seluruh data biodata perawat dan memantau kehadiran harian secara real-time.</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="role-card border-top border-success border-4">
                <div class="role-icon icon-admin shadow-sm">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="role-title">Administrasi & Keuangan</div>
                <div class="role-desc">Akses khusus untuk memvalidasi permohonan cuti dan mendistribusikan tunjangan gaji bulanan dengan cepat dan akurat.</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="role-card border-top border-danger border-4">
                <div class="role-icon icon-nurse shadow-sm">
                    <i class="bi bi-clipboard-pulse"></i>
                </div>
                <div class="role-title">Karyawan Perawat</div>
                <div class="role-desc">Ruang personal bagi perawat untuk melakukan presensi, mengajukan cuti mandiri, dan melihat slip gaji bulan berjalan.</div>
            </div>
        </div>

    </div>
</div>

</body>
</html>