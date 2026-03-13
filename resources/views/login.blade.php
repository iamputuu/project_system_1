<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Karyawan Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* Gaya minimalis ala Apple/iCloud */
        body {
            background-color: #f5f5f7; /* Warna abu-abu khas latar Apple */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px; /* Sudut melengkung halus */
            box-shadow: 0 4px 24px rgba(0,0,0,0.04); /* Bayangan sangat lembut */
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            border: none;
            text-align: center;
        }
        .logo-icon {
            font-size: 3.5rem;
            color: #1d1d1f; /* Warna hitam elegan */
            margin-bottom: 10px;
        }
        .login-title {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 30px;
            color: #1d1d1f;
        }
        .form-control {
            border-radius: 12px;
            padding: 14px 16px;
            background-color: #f5f5f7; /* Warna form abu-abu muda */
            border: 1px solid transparent;
            margin-bottom: 15px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #0071e3; /* Warna biru fokus ala Apple */
            box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
        }
        /* Menghilangkan panah/outline bawaan browser */
        .form-control::placeholder {
            color: #86868b;
        }
        .btn-login {
            background-color: #0077ed; /* Tombol gelap elegan */
            color: white;
            border-radius: 24px; /* Tombol pil */
            padding: 12px;
            font-weight: 500;
            font-size: 1rem;
            width: 100%;
            border: none;
            margin-top: 15px;
            transition: 0.2s;
        }
        .btn-login:hover {
            background-color: #424245; /* Sedikit terang saat di-hover */
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-icon">
        <i class="bi bi-heart-pulse"></i>
    </div>
    
    <div class="login-title">Masuk ke Sistem Perawat</div>
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autocomplete="off" autofocus>
        
        <input type="password" class="form-control" id="password" name="password" placeholder="Sandi" required>
        
        <button type="submit" class="btn btn-login">
            Lanjutkan <i class="bi bi-arrow-right-short align-middle fs-4"></i>
        </button>
    </form>
</div>

</body>
</html>