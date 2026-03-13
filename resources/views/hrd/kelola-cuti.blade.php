<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengajuan Cuti - HRD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0"><i class="bi bi-ui-checks text-primary me-2"></i>Persetujuan Cuti Karyawan</h3>
            <p class="text-muted">Kelola pengajuan cuti dari para perawat</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>TGL PENGAJUAN</th>
                            <th>NIK KARYAWAN</th>
                            <th>TGL CUTI (MULAI - SELESAI)</th>
                            <th>ALASAN</th>
                            <th>STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semua_cuti as $c)
                        <tr>
                            <td class="small">{{ \Carbon\Carbon::parse($c->tgl_pengajuan)->format('d M Y') }}</td>
                            
                            <td class="fw-bold">{{ $c->nik }}</td>
                            
                            <td>
                                <span class="d-block fw-medium">{{ \Carbon\Carbon::parse($c->tgl_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($c->tgl_selesai)->format('d M Y') }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($c->tgl_mulai)->diffInDays($c->tgl_selesai) + 1 }} Hari</small>
                            </td>
                            
                            <td style="max-width: 200px;" class="text-truncate" title="{{ $c->alasan_cuti }}">
                                {{ $c->alasan_cuti }}
                            </td>
                            
                            <td>
                                @if($c->status_persetujuan == 'Menunggu')
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">Menunggu</span>
                                @elseif($c->status_persetujuan == 'Disetujui')
                                    <span class="badge bg-success px-3 rounded-pill">Disetujui</span>
                                @else
                                    <span class="badge bg-danger px-3 rounded-pill">Ditolak</span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                @if($c->status_persetujuan == 'Menunggu')
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.cuti.update', $c->id_cuti) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_persetujuan" value="Disetujui">
                                            <button type="submit" class="btn btn-sm btn-success fw-bold" title="Setujui Cuti" onclick="return confirm('Yakin ingin menyetujui cuti ini?')">
                                                <i class="bi bi-check2"></i> Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.cuti.update', $c->id_cuti) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_persetujuan" value="Ditolak">
                                            <button type="submit" class="btn btn-sm btn-danger fw-bold" title="Tolak Cuti" onclick="return confirm('Yakin ingin menolak cuti ini?')">
                                                <i class="bi bi-x-lg"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic"><i class="bi bi-lock"></i> Selesai diproses</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i> Belum ada pengajuan cuti.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>