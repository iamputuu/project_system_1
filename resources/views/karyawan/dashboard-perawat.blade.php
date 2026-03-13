<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Perawat - Sistem Karyawan</title>
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
        .btn-absen { border-radius: 10px; padding: 12px; font-weight: bold; font-size: 1.05rem; }
    </style>
</head>
<body>

@php
    $list_cuti = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)->orderBy('id_cuti', 'desc')->get();
    
    $cuti_approved = \App\Models\DataCutiKaryawan::where('nik', $perawat->username)->where('status_persetujuan', 'Disetujui')->get();
    $total_hari_terpakai = 0;
    foreach($cuti_approved as $c) {
        $start = \Carbon\Carbon::parse($c->tgl_mulai);
        $end = \Carbon\Carbon::parse($c->tgl_selesai);
        $total_hari_terpakai += $start->diffInDays($end) + 1;
    }
    $sisa_cuti = 12 - $total_hari_terpakai;

    $riwayat_tunjangan = \App\Models\DataTunjanganKaryawan::where('nik', $perawat->username)
                        ->orderBy('periode_bulan', 'desc')
                        ->get();
    
    $tunjangan_ku = $riwayat_tunjangan->first();
@endphp

<div class="top-navbar d-flex justify-content-between align-items-center sticky-top">
    <div class="d-flex align-items-center">
        <div class="bg-primary bg-opacity-25 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-heart-pulse-fill fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0">Portal Perawat</h5>
    </div>
    
    <div class="d-flex align-items-center gap-4">
        <span class="text-white-50 small d-none d-md-block">
            <i class="bi bi-person-badge me-1"></i> NIK: {{ $perawat->username }}
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
            <h3 class="mb-1 fw-bold">Selamat Bertugas, {{ $perawat->name }}! 🩺</h3>
            <p class="text-muted mb-0">Divisi: Keperawatan Klinis</p>
        </div>
        <div class="text-md-end bg-light p-3 rounded-3 border">
            <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Waktu Saat Ini</small>
            <h4 class="mb-0 fw-bold text-primary" id="liveTime">00:00:00</h4>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card stat-card p-4 h-100 border-start border-primary border-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-fingerprint me-2"></i>Aksi Presensi Hari Ini</h6>
                @if(session('success')) <div class="alert alert-success py-2 mt-2 small text-center">{{ session('success') }}</div> @endif
                @if(session('error')) <div class="alert alert-danger py-2 mt-2 small text-center">{{ session('error') }}</div> @endif
                
                <div class="d-flex gap-2 mt-auto">
                    <form action="{{ route('presensi.masuk') }}" method="POST" class="w-50">
                        @csrf <button type="submit" class="btn btn-primary w-100 btn-absen shadow-sm">Catat Masuk</button>
                    </form>
                    <form action="{{ route('presensi.pulang') }}" method="POST" class="w-50">
                        @csrf <button type="submit" class="btn btn-light border border-2 w-100 btn-absen text-dark shadow-sm">Catat Pulang</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card p-4 h-100 border-start border-info border-4">
                <h6 class="fw-bold text-info mb-3"><i class="bi bi-calendar2-plus me-2"></i>Rencana Libur / Cuti?</h6>
                <div class="d-flex align-items-center justify-content-between mt-auto">
                    <div>
                        <small class="text-muted d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Sisa Cuti Tahunan</small>
                        <h2 class="fw-bold mb-0 text-dark">{{ $sisa_cuti }} <span class="fs-6 fw-normal text-muted">Hari</span></h2>
                    </div>
                    <button class="btn btn-info text-white btn-absen px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCuti">
                        <i class="bi bi-plus-lg me-1"></i> Ajukan Cuti Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card stat-card p-4 mb-4 border-0 bg-warning bg-opacity-10">
        <h6 class="fw-bold text-warning text-darken mb-3"><i class="bi bi-megaphone-fill me-2"></i>Papan Pengumuman RS</h6>
        <div class="row g-2">
            @foreach($pengumuman_rs as $info)
                <div class="col-md-4">
                    <div class="bg-white p-3 rounded-3 shadow-sm h-100 d-flex align-items-start border border-warning border-opacity-25">
                        <i class="bi bi-info-circle-fill text-warning me-2 mt-1"></i>
                        <span class="small text-dark">{{ $info }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card stat-card p-4 h-100 border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0 text-secondary text-uppercase" style="letter-spacing: 1px;">Status Persetujuan Cuti</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-top">
                        <thead class="bg-light text-muted small">
                            <tr><th>TANGGAL MULAI</th><th>DURASI</th><th>ALASAN</th><th>STATUS</th></tr>
                        </thead>
                        <tbody>
                            @forelse($list_cuti as $c)
                            <tr>
                                <td class="fw-bold text-dark">{{ \Carbon\Carbon::parse($c->tgl_mulai)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($c->tgl_mulai)->diffInDays($c->tgl_selesai) + 1 }} Hari</td>
                                <td class="text-muted small" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $c->alasan_cuti }}">{{ $c->alasan_cuti }}</td>
                                <td>
                                    @if($c->status_persetujuan == 'Menunggu') <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>
                                    @elseif($c->status_persetujuan == 'Disetujui') <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                    @else <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-5">Belum ada riwayat pengajuan cuti.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card stat-card p-4 h-100" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white;">
                <h6 class="fw-bold mb-4 opacity-75 text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-wallet2 me-2"></i>Tunjangan Terbaru</h6>
                
                @if($tunjangan_ku)
                    <h1 class="fw-extrabold mb-1">Rp {{ number_format($tunjangan_ku->total_tunjangan, 0, ',', '.') }}</h1>
                    <p class="opacity-75 small mb-5 border-bottom border-light border-opacity-25 pb-3">Periode: {{ \Carbon\Carbon::parse($tunjangan_ku->periode_bulan)->format('F Y') }}</p>
                    
                    <div class="mt-auto d-flex flex-column gap-3">
                        <button class="btn btn-light fw-bold text-success py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDetailTunjangan">
                            <i class="bi bi-receipt me-1"></i> Slip Bulan Ini
                        </button>
                        <button class="btn border border-light text-white fw-bold py-2 hover-bg-light" data-bs-toggle="modal" data-bs-target="#modalRiwayatTunjangan">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Lengkap
                        </button>
                    </div>
                @else
                    <h1 class="fw-extrabold mb-1 opacity-50">Rp ---</h1>
                    <p class="opacity-75 small mb-4">Belum ada data finalisasi dari Keuangan.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCuti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-info text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">Form Pengajuan Cuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cuti.simpan') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Tanggal Selesai</label>
                            <input type="date" name="tgl_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Alasan Cuti</label>
                        <textarea name="alasan_cuti" class="form-control" rows="3" required placeholder="Jelaskan alasan secara singkat..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-info text-white py-2 rounded-pill w-100 fw-bold">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($tunjangan_ku)
<div class="modal fade" id="modalDetailTunjangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2"></i>Slip Tunjangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4 pb-3 border-bottom border-dashed">
                    <h6 class="text-muted mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Total Pendapatan</h6>
                    <h1 class="fw-extrabold text-success mb-2">Rp {{ number_format($tunjangan_ku->total_tunjangan, 0, ',', '.') }}</h1>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">Periode: {{ \Carbon\Carbon::parse($tunjangan_ku->periode_bulan)->format('F Y') }}</span>
                </div>
                <div class="px-2">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Nominal Gaji Dasar</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($tunjangan_ku->nominal_dasar, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tunjangan Tambahan</span>
                        <span class="fw-bold text-success">+ Rp {{ number_format($tunjangan_ku->total_tunjangan - $tunjangan_ku->nominal_dasar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRiwayatTunjangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-dark text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-clock-history me-2"></i>Riwayat Tunjangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">PERIODE</th>
                                <th>GAJI DASAR</th>
                                <th>TOTAL DITERIMA</th>
                                <th class="pe-4 text-end">TANGGAL CAIR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat_tunjangan as $r)
                            <tr>
                                <td class="ps-4 fw-bold">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-check text-success me-2"></i>
                                        {{ \Carbon\Carbon::parse($r->periode_bulan)->format('F Y') }}
                                    </div>
                                </td>
                                <td class="text-muted">Rp {{ number_format($r->nominal_dasar, 0, ',', '.') }}</td>
                                <td class="fw-bold text-success">Rp {{ number_format($r->total_tunjangan, 0, ',', '.') }}</td>
                                <td class="pe-4 text-end small text-muted">{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('liveTime').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
</body>
</html>