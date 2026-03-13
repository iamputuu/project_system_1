<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin & Keuangan - Sistem Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: -apple-system, sans-serif; }
        .top-navbar { background: #1d1d1f; color: white; padding: 15px 5%; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .logout-btn { color: #ff4d4f; text-decoration: none; font-weight: 600; background: none; border: none; padding: 0; }
        .logout-btn:hover { color: #ff7875; }
        .main-content { padding: 40px 5%; max-width: 1400px; margin: 0 auto; }
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); transition: 0.3s; background: white; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .welcome-banner { background: white; border-radius: 15px; padding: 25px 30px; margin-bottom: 30px; border: 1px solid #eee; }
    </style>
</head>
<body>

@php
    $cuti_pending = \App\Models\DataCutiKaryawan::with('karyawan')
                    ->where('status_persetujuan', 'Menunggu')
                    ->orderBy('tgl_pengajuan', 'asc')
                    ->get();
    $total_pending = $cuti_pending->count();

    $semua_perawat = \App\Models\User::where('role', 'perawat')->get();

    $riwayat_tunjangan = \App\Models\DataTunjanganKaryawan::orderBy('id_tunjangan', 'desc')->get();

    $total_karyawan = \App\Models\User::where('role', 'perawat')->count();
@endphp

<div class="top-navbar d-flex justify-content-between align-items-center sticky-top">
    <div class="d-flex align-items-center gap-4">
        <div class="d-flex align-items-center me-4">
            <div class="bg-warning bg-opacity-25 text-warning rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-wallet2 fs-5"></i>
            </div>
            <h5 class="fw-bold mb-0">Portal Admin</h5>
        </div>
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <span class="text-white-50 small d-none d-md-block">
            <i class="bi bi-shield-lock-fill me-1 text-success"></i> Akses Administrasi & Keuangan
        </span>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="logout-btn d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2 fs-5"></i> <span class="d-none d-sm-block">Keluar</span>
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="welcome-banner d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h3 class="mb-1 fw-bold">Semangat Pagi, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-muted mb-0">Ringkasan persetujuan cuti dan estimasi tunjangan hari ini.</p>
        </div>
        <div class="text-md-end bg-light p-3 rounded-3 border">
            <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Sesi Aktif</small>
            <h5 class="mb-0 fw-bold text-primary">{{ ucfirst(Auth::user()->role) }} Utama</h5>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card p-3 border-start border-info border-4 h-100" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalDataKaryawan" title="Klik untuk melihat daftar karyawan">
                <div class="d-flex align-items-center h-100">
                    <div class="icon-box bg-info bg-opacity-10 text-info p-3 rounded-circle me-3"><i class="bi bi-person-lines-fill fs-4"></i></div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Data Karyawan</small>
                        <h5 class="fw-bold mb-0 text-info mt-1">Lihat Detail <i class="bi bi-arrow-right-short align-middle fs-4"></i></h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card p-3 border-start border-primary border-4 h-100">
                <div class="d-flex align-items-center h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3"><i class="bi bi-file-earmark-bar-graph fs-4"></i></div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Total Karyawan</small>
                        <h4 class="fw-bold mb-0">{{ $total_karyawan }} <span class="fs-6 fw-normal text-muted">Aktif</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card p-3 h-100" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white;">
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-white text-success p-3 rounded-circle me-3 shadow-sm"><i class="bi bi-cash-stack fs-4"></i></div>
                        <div>
                            <small class="text-white-50 d-block fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Distribusi Gaji</small>
                            <h4 class="fw-bold mb-0">Siklus Tunjangan</h4>
                        </div>
                    </div>
                    <button class="btn btn-light fw-bold text-success px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTunjangan">
                        <i class="bi bi-send-fill me-1"></i> Kirim Gaji
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card stat-card p-4 border-0 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0 text-uppercase text-secondary" style="letter-spacing: 1px;"><i class="bi bi-clock-history text-muted me-2"></i>Riwayat Pengiriman Tunjangan</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-top">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 border-0">TANGGAL KIRIM</th>
                                <th class="border-0">NIK PERAWAT</th>
                                <th class="pe-3 text-end border-0">TOTAL DIKIRIM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_tunjangan as $tunjangan)
                            <tr>
                                <td class="ps-3 text-muted small">
                                    {{ \Carbon\Carbon::parse($tunjangan->created_at)->format('d M Y, H:i') }}<br>
                                    <span class="badge bg-success bg-opacity-10 text-success mt-1 rounded-pill border border-success border-opacity-25">
                                        <i class="bi bi-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($tunjangan->periode_bulan)->format('F Y') }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">{{ $tunjangan->nik }}</td>
                                <td class="pe-3 text-end fw-extrabold text-success">Rp {{ number_format($tunjangan->total_tunjangan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5 border-bottom-0">Belum ada riwayat pengiriman tunjangan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card p-4 border-0 border-top border-warning border-3 h-100">
                <h6 class="fw-bold mb-4 text-uppercase text-secondary" style="letter-spacing: 1px;"><i class="bi bi-hourglass-split text-warning me-2"></i>Antrean Persetujuan Cuti</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-3 border-0">NAMA / NIK</th>
                                <th class="border-0">TANGGAL & ALASAN</th>
                                <th class="text-center pe-3 border-0">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuti_pending as $cuti)
                            <tr>
                                <td class="ps-3 border-bottom-0">
                                    <div class="d-flex align-items-center my-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3"><i class="bi bi-person-fill fs-5"></i></div>
                                        <div>
                                            <span class="d-block fw-bold text-dark">{{ $cuti->karyawan->nama_lengkap ?? $cuti->nik }}</span>
                                            <small class="text-muted">{{ $cuti->nik }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="d-block fw-medium text-dark" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d M Y') }}</span>
                                    <small class="text-muted text-truncate d-block" style="max-width: 150px;" title="{{ $cuti->alasan_cuti }}">{{ $cuti->alasan_cuti }}</small>
                                </td>
                                <td class="text-center pe-3 border-bottom-0">
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('admin.cuti.update', $cuti->id_cuti) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status_persetujuan" value="Disetujui">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 fw-bold shadow-sm" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                        <form action="{{ route('admin.cuti.update', $cuti->id_cuti) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status_persetujuan" value="Ditolak">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 fw-bold shadow-sm" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5 border-bottom-0">
                                    <i class="bi bi-check2-all fs-1 d-block mb-2 text-success opacity-50"></i>
                                    Semua pengajuan cuti telah diproses. Tidak ada antrean.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalDataKaryawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-info text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-people-fill me-2"></i>Daftar Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small sticky-top">
                            <tr>
                                <th class="ps-4 py-3 border-0">NAMA LENGKAP</th>
                                <th class="pe-4 py-3 border-0 text-end">NIK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semua_perawat as $p)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 text-end text-muted fw-medium">{{ $p->username }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-5">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 p-3 bg-light" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTunjangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-cash-stack me-2"></i>Form Pengiriman Gaji</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('tunjangan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Pilih Akun Perawat</label>
                        <select name="nik" class="form-select form-select-lg bg-light border-0" required style="font-size: 0.95rem;">
                            <option value="">-- Pilih Perawat Tujuan --</option>
                            @foreach($semua_perawat as $p)
                                <option value="{{ $p->username }}">{{ $p->name }} ({{ $p->username }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Periode Pembayaran</label>
                        <input type="month" name="periode_bulan" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <div class="p-3 bg-light rounded-3 mb-2 border">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Nominal Dasar Gaji (Rp)</label>
                            <input type="number" name="nominal_dasar" class="form-control fw-bold text-success" placeholder="Contoh: 3500000" required>
                        </div>
                        <div class="mb-1">
                            <label class="form-label small fw-bold text-muted">Tunjangan Tambahan / Bonus</label>
                            <input type="number" name="tunjangan_tambahan" class="form-control fw-bold text-success" placeholder="Contoh: 1500000 (Opsional)" value="0">
                        </div>
                    </div>
                    <small class="text-success fst-italic d-block text-center mt-2" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Sistem otomatis menjumlahkan total yang dikirim.</small>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 mt-2">
                    <button type="submit" class="btn btn-success text-white w-100 py-3 rounded-pill fw-bold" style="font-size: 1.1rem; box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);">Konfirmasi & Kirim Tunjangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>