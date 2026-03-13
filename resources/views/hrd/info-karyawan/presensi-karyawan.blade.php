<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi - HRD</title>
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
                    <a class="nav-link" href="{{ route('karyawan.index') }}"><i class="bi bi-people-fill me-1"></i> Data User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('presensi.index') }}"><i class="bi bi-clock-fill me-1"></i> Presensi</a>
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
            <h4 class="fw-bold mb-0" style="color: #2b3674;">Pemantauan Presensi Harian</h4>
            <p class="text-muted mb-0">Tanggal: {{ \Carbon\Carbon::now('Asia/Makassar')->format('d F Y') }}</p>
        </div>
    </div>

    @php
        $hari_ini = \Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d');
        $semua_perawat = \App\Models\DataKaryawan::all();
        $absen_hari_ini = \App\Models\DataPresensi::where('tanggal', $hari_ini)->get();
    @endphp

    <div class="card card-custom">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h5 class="fw-bold mb-0" style="color: #2b3674;">Daftar Presensi Perawat</h5>
            
            <div class="d-flex gap-2 justify-content-md-end w-100" style="max-width: 400px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 rounded-start-pill text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control bg-light border-0 rounded-end-pill focus-ring focus-ring-light shadow-none" placeholder="Cari NIK Perawat...">
                </div>
            </div>
        </div>

        <div class="card-body p-4 pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3 px-2">NAMA PERAWAT</th>
                            <th class="py-3">JADWAL SHIFT</th>
                            <th class="py-3">JAM MASUK</th>
                            <th class="py-3">JAM KELUAR</th>
                            <th class="py-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semua_perawat as $perawat)
                            @php
                                $absen = $absen_hari_ini->where('nik', $perawat->nik)->first();
                            @endphp
                            <tr class="data-row">
                                <td class="px-2">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold" style="color: #2b3674;">{{ $perawat->nama_lengkap }}</span>
                                        <small class="text-muted nik-column">{{ $perawat->nik }}</small>
                                    </div>
                                </td>
                                <td class="text-muted fw-medium">Pagi (07:00 - 15:00)</td>
                                
                                <td>
                                    @if($absen && $absen->jam_masuk)
                                        <span class="text-success fw-bold"><i class="bi bi-box-arrow-in-right me-1"></i> {{ $absen->jam_masuk }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Belum ada data</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($absen && $absen->jam_keluar)
                                        <span class="text-danger fw-bold"><i class="bi bi-box-arrow-left me-1"></i> {{ $absen->jam_keluar }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($absen && $absen->jam_masuk)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fw-semibold">Hadir</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill fw-semibold">Belum Absen</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center justify-content-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-clock-history fs-1 text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold">Belum ada data karyawan.</h6>
                                        <small>Data presensi akan muncul jika karyawan sudah terdaftar.</small>
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