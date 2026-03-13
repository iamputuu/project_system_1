<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - HRD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; overflow-x: hidden; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.04); padding: 15px 0; }
        .navbar-custom .nav-link { font-weight: 500; color: #6c757d; border-radius: 8px; padding: 8px 16px; margin: 0 5px; transition: 0.3s; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { background-color: #f4f7fe; color: #0071e3; }
        
        .card-custom { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
        .table th { font-size: 0.85rem; letter-spacing: 0.5px; color: #8f9bba; text-transform: uppercase; border-bottom: 1px solid #e9ecef; }
        .table td { border-bottom: 1px solid #f4f7fe; vertical-align: middle; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom mb-5">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#" style="color: #1d1d1f;">
            <div class="bg-primary text-white rounded p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="bi bi-hospital fs-5"></i>
            </div>
            HR SYSTEM
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill me-1"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('karyawan.index') }}"><i class="bi bi-people-fill me-1"></i> Data User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('presensi.index') }}"><i class="bi bi-clock-fill me-1"></i> Presensi</a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex m-0">
                @csrf
                <button type="submit" class="btn btn-light text-danger fw-bold rounded-pill px-4" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <div>
            <h4 class="fw-bold mb-0" style="color: #2b3674;">Manajemen User Perawat</h4>
            <p class="text-muted mb-0">Kelola profil, status, dan akses sistem karyawan.</p>
        </div>
        <div>
            <a href="{{ route('hrd.tambah-karyawanz') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Tambah User baru
            </a>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-end">
            <div class="input-group shadow-sm" style="max-width: 300px; border-radius: 50px; overflow: hidden;">
                <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control bg-light border-0 shadow-none py-2" placeholder="Cari NIK / Username...">
            </div>
        </div>

        <div class="card-body p-4 pt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">NIK / USERNAME</th>
                            <th class="py-3">NAMA LENGKAP</th>
                            <th class="py-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_perawat as $perawat)
                        <tr class="data-row">
                            <td class="px-4 fw-bold text-dark nik-column">{{ $perawat->username }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <span class="fw-semibold" style="color: #2b3674;">{{ $perawat->name }}</span>
                                </div>
                            </td>
                           
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('hrd.updatez', $perawat->id) }}" class="btn btn-light text-warning shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Edit Data">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a> 
                                    
                                    <form action="{{ route('hrd.deleted', $perawat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perawat ini secara permanen?');">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-danger shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" title="Hapus/Resign">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-people-fill fs-1 text-secondary"></i>
                                    </div>
                                    <h6 class="fw-bold">Belum ada data perawat di sistem.</h6>
                                    <small>Silakan klik Tambah User baru untuk memasukkan data.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <tr id="noSearchResult" style="display: none;">
                            <td colspan="3" class="text-center py-4 text-muted fst-italic">
                                NIK atau Username tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('.data-row');
        let hasResult = false;

        rows.forEach(row => {
            let nikCell = row.querySelector('.nik-column');
            if (nikCell) {
                let nikText = nikCell.textContent || nikCell.innerText;
                if (nikText.toUpperCase().indexOf(filter) > -1) {
                    row.style.display = "";
                    hasResult = true;
                } else {
                    row.style.display = "none";
                }
            }
        });

        let noSearchResult = document.getElementById('noSearchResult');
        let emptyRow = document.getElementById('emptyRow');
        
        if(!emptyRow) {
            if (!hasResult && filter !== "") {
                noSearchResult.style.display = "";
            } else {
                noSearchResult.style.display = "none";
            }
        }
    });
</script>

</body>
</html>