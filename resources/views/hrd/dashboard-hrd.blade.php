<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard HRD - Sistem Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; overflow-x: hidden; }
        
        .navbar-custom { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.04); padding: 15px 0; }
        .navbar-custom .nav-link { font-weight: 500; color: #6c757d; border-radius: 8px; padding: 8px 16px; margin: 0 5px; transition: 0.3s; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { background-color: #f4f7fe; color: #0071e3; }
        
        .gradient-banner { background: linear-gradient(135deg, #0071e3 0%, #4facfe 100%); color: white; border-radius: 20px; padding: 35px; border: none; box-shadow: 0 10px 30px rgba(0, 113, 227, 0.2); }
        .gradient-banner p { color: rgba(255, 255, 255, 0.8) !important; }
        .gradient-banner small { color: rgba(255, 255, 255, 0.7) !important; }
        
        .card-custom { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; }
        .stat-card { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-7px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .icon-box { width: 54px; height: 54px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        
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
                    <a class="nav-link active" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill me-1"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('karyawan.index') }}"><i class="bi bi-people-fill me-1"></i> Data User</a>
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
    
    <div class="gradient-banner d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="mb-1 fw-bold">Semangat Pagi! 👋</h3>
            <p class="mb-0">Berikut adalah ringkasan data perawat hari ini.</p>
        </div>
        <div class="text-end d-none d-md-block">
            <h5 class="mb-0 fw-bold">Human Resource</h5>
            <small>Denpasar, Bali</small>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle me-3"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <small class="text-muted fw-semibold d-block">Total Perawat</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $total_perawat ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle me-3"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <small class="text-muted fw-semibold d-block">Hadir Hari Ini</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $hadir_hari_ini ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle me-3"><i class="bi bi-envelope-paper-fill"></i></div>
                    <div>
                        <small class="text-muted fw-semibold d-block">Izin/Cuti</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $izin_cuti ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle me-3"><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div>
                        <small class="text-muted fw-semibold d-block">Belum Absen</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $belum_absen ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h5 class="fw-bold mb-0" style="color: #2b3674;">Daftar Biodata Karyawan</h5>
            
            <div class="d-flex gap-2 justify-content-md-end w-100" style="max-width: 400px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 rounded-start-pill text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control bg-light border-0 rounded-end-pill focus-ring focus-ring-light shadow-none" placeholder="Cari NIK Perawat...">
                </div>
                
                <a href="{{ route('biodata.store') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold d-flex align-items-center text-nowrap">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body p-4 pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="employeeTable">
                    <thead>
                        <tr>
                            <th class="py-3 px-4">NIK</th>
                            <th class="py-3">NAMA LENGKAP</th>
                            <th class="py-3">JABATAN</th>
                            <th class="py-3">STATUS</th>
                            <th class="py-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyawan_lengkap as $kar)
                        <tr class="data-row">
                            <td class="px-4 fw-bold text-dark nik-column">{{ $kar->nik }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <span class="fw-semibold" style="color: #2b3674;">{{ $kar->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="text-muted fw-medium">{{ $kar->jabatan }}</td>
                            <td>
                                @if($kar->status_karyawan == 'Aktif')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fw-semibold">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill fw-semibold">{{ $kar->status_karyawan }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-light text-warning shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $kar->nik }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <form action="{{ route('biodata.delete', $kar->nik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $kar->nik }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <form action="{{ route('biodata.update', $kar->nik) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 pb-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">Edit Biodata: <span class="text-primary">{{ $kar->nik }}</span></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control rounded-3 py-2" value="{{ $kar->nama_lengkap }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Jabatan</label>
                                                <select name="jabatan" class="form-select rounded-3 py-2">
                                                    <option value="Perawat Terampil" {{ $kar->jabatan == 'Perawat Terampil' ? 'selected' : '' }}>Perawat Terampil</option>
                                                    <option value="Perawat Mahir" {{ $kar->jabatan == 'Perawat Mahir' ? 'selected' : '' }}>Perawat Mahir</option>
                                                    <option value="Perawat Penyelia" {{ $kar->jabatan == 'Perawat Penyelia' ? 'selected' : '' }}>Perawat Penyelia</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Status</label>
                                                <select name="status_karyawan" class="form-select rounded-3 py-2">
                                                    <option value="Aktif" {{ $kar->status_karyawan == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Resign" {{ $kar->status_karyawan == 'Resign' ? 'selected' : '' }}>Resign</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 px-4 pb-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-folder-x fs-1 text-secondary"></i>
                                    </div>
                                    <h6 class="fw-bold">Belum ada data karyawan</h6>
                                    <small>Silakan klik Tambah Data untuk memasukkan biodata baru.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <tr id="noSearchResult" style="display: none;">
                            <td colspan="5" class="text-center py-4 text-muted fst-italic">
                                NIK tidak ditemukan.
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

        // Tampilkan pesan jika NIK tidak ada yang cocok
        let noSearchResult = document.getElementById('noSearchResult');
        let emptyRow = document.getElementById('emptyRow');
        
        // Jangan jalankan jika memang tabelnya kosong dari awal
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