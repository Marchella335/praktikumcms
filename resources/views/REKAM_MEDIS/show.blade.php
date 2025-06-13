@extends('layouts.app')

@section('title', 'Detail Rekam Medis - RS Cepat Sembuh')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Detail Rekam Medis</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('rekam_medis.index') }}">Rekam Medis</a>
                            </li>
                            <li class="breadcrumb-item active">ID: {{ $rekamMedis->id_rekam_medis }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <a href="{{ route('rekam_medis.edit', ['id' => $rekamMedis->id_rekam_medis]) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Info Card -->
        <div class="col-lg-8">
            <!-- Header Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-medical me-2"></i>Informasi Umum
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">ID REKAM MEDIS</label>
                                <div class="h6">
                                    <span class="badge bg-light text-dark fs-6">{{ $rekamMedis->id_rekam_medis }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">NAMA PASIEN</label>
                                <div class="h6">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    <span>{{ $rekamMedis->nama_pasien }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">DOKTER PEMERIKSA</label>
                                <div class="h6">
                                    <i class="fas fa-user-md me-2 text-success"></i>
                                    <span>{{ $rekamMedis->nama_dokter }}</span>
                                    @if($rekamMedis->spesialisasi)
                                        <small class="text-muted d-block">{{ $rekamMedis->spesialisasi }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">TANGGAL PEMERIKSAAN</label>
                                <div class="h6">
                                    <i class="fas fa-calendar me-2 text-info"></i>
                                    <span>{{ Carbon::parse($rekamMedis->tanggal)->format('d F Y') }}</span>
                                    <small class="text-muted d-block">{{ Carbon::parse($rekamMedis->tanggal)->diffForHumans() }}</small>
                                </div>
                            </div>
                            
                            @if($rekamMedis->nama_staf)
                            <div class="mb-4">
                                <label class="form-label text-muted small">STAF PENDAMPING</label>
                                <div class="h6">
                                    <i class="fas fa-user-nurse me-2 text-warning"></i>
                                    <span>{{ $rekamMedis->nama_staf }}</span>
                                </div>
                            </div>
                            @endif
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">INFORMASI PASIEN</label>
                                <div class="small">
                                    @if($rekamMedis->nomor_telepon)
                                        <div class="mb-1">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            {{ $rekamMedis->nomor_telepon }}
                                        </div>
                                    @endif
                                    @if($rekamMedis->alamat)
                                        <div>
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            {{ $rekamMedis->alamat }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-stethoscope me-2"></i>Detail Pemeriksaan
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Diagnosa -->
                    <div class="mb-4">
                        <label class="form-label text-muted small">DIAGNOSA</label>
                        <div class="p-3 bg-light rounded">
                            <div class="h6 text-danger mb-0">
                                <i class="fas fa-diagnoses me-2"></i>
                                {{ $rekamMedis->diagnosa }}
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Pemeriksaan -->
                    <div class="mb-4">
                        <label class="form-label text-muted small">HASIL PEMERIKSAAN</label>
                        <div class="p-3 border rounded">
                            <div class="text-dark">
                                {!! nl2br(e($rekamMedis->hasil_pemeriksaan)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Tindakan -->
                    <div class="mb-4">
                        <label class="form-label text-muted small">TINDAKAN MEDIS</label>
                        <div class="p-3 bg-info bg-opacity-10 border border-info rounded">
                            <div class="text-dark">
                                <i class="fas fa-procedures me-2 text-info"></i>
                                {!! nl2br(e($rekamMedis->tindakan)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Obat -->
                    @if($rekamMedis->obat)
                    <div class="mb-4">
                        <label class="form-label text-muted small">OBAT YANG DIBERIKAN</label>
                        <div class="p-3 bg-success bg-opacity-10 border border-success rounded">
                            <div class="text-dark">
                                <i class="fas fa-pills me-2 text-success"></i>
                                {!! nl2br(e($rekamMedis->obat)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Riwayat Rekam Medis -->
                    @if($rekamMedis->riwayat_rekam_medis)
                    <div class="mb-4">
                        <label class="form-label text-muted small">RIWAYAT REKAM MEDIS</label>
                        <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                            <div class="text-dark">
                                <i class="fas fa-history me-2 text-warning"></i>
                                {!! nl2br(e($rekamMedis->riwayat_rekam_medis)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('rekam_medis.edit', ['id' => $rekamMedis->id_rekam_medis]) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Edit Rekam Medis
                        </a>
                        
                        <button type="button" class="btn btn-outline-danger" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus Rekam Medis
                        </button>
                        
                        <a href="#" class="btn btn-outline-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Side Info Cards -->
        <div class="col-lg-4">
            <!-- Summary Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Ringkasan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status Pemeriksaan</small>
                        <div>
                            <span class="badge bg-success">Selesai</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Waktu Pemeriksaan</small>
                        <div>
                            <span class="badge bg-info">{{ Carbon::parse($rekamMedis->tanggal)->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Tipe Diagnosa</small>
                        <div>
                            @php
                                $diagnosaParts = explode(' ', strtolower($rekamMedis->diagnosa));
                                $isEmergency = false;
                                $emergencyKeywords = ['darurat', 'emergency', 'akut', 'kritis', 'gawat'];
                                foreach ($emergencyKeywords as $keyword) {
                                    if (in_array($keyword, $diagnosaParts)) {
                                        $isEmergency = true;
                                        break;
                                    }
                                }
                            @endphp
                            
                            @if($isEmergency)
                                <span class="badge bg-danger">Darurat</span>
                            @else
                                <span class="badge bg-primary">Normal</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Kontak Pasien</small>
                        <div class="text-sm">
                            @if($rekamMedis->nomor_telepon)
                                <i class="fas fa-phone text-success me-1"></i>
                                <a href="tel:{{ $rekamMedis->nomor_telepon }}" class="text-decoration-none">
                                    {{ $rekamMedis->nomor_telepon }}
                                </a>
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('rekam_medis.create') }}?pasien_id={{ $rekamMedis->id_pasien }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Rekam Medis Baru
                        </a>
                        
                        <a href="{{ route('janji_temu.create') }}?pasien_id={{ $rekamMedis->id_pasien }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu
                        </a>
                        
                        <a href="{{ route('rekam_medis.by_pasien', ['id' => $rekamMedis->id_pasien]) }}" class="btn btn-outline-info btn-sm">Lihat Data Pasien</a>
                            <i class="fas fa-history me-2"></i>Riwayat Pasien
                        </a>
                        
                        <a href="{{ route('rekam_medis.by_dokter', ['id' => $rekamMedis->id_dokter]) }}" class="btn btn-outline-warning btn-sm">Lihat Data Dokter</a>
                            <i class="fas fa-user-md me-2"></i>Rekam Medis Dokter
                        </a>
                        
                        <a href="{{ route('rekam_medis.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>
            </div>

            <!-- Medical Timeline Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Timeline Medis
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pemeriksaan Selesai</h6>
                                <p class="timeline-text">{{ Carbon::parse($rekamMedis->tanggal)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($rekamMedis->riwayat_rekam_medis)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Riwayat Tercatat</h6>
                                <p class="timeline-text">Data riwayat medis tersedia</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($rekamMedis->obat)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Obat Diberikan</h6>
                                <p class="timeline-text">Resep obat telah diberikan</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus rekam medis berikut?</p>
                <div class="alert alert-light">
                    <strong>ID Rekam Medis:</strong> {{ $rekamMedis->id_rekam_medis }}<br>
                    <strong>Pasien:</strong> {{ $rekamMedis->nama_pasien }}<br>
                    <strong>Dokter:</strong> {{ $rekamMedis->nama_dokter }}<br>
                    <strong>Tanggal:</strong> {{ Carbon::parse($rekamMedis->tanggal)->format('d F Y') }}<br>
                    <strong>Diagnosa:</strong> {{ Str::limit($rekamMedis->diagnosa, 50) }}
                </div>
                <p class="text-danger small">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form action="{{ route('rekam_medis.destroy', ['id' => $rekamMedis->id_rekam_medis]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 2px;
}

.timeline-text {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0;
}

@media print {
    .btn, .modal, .card-header, nav {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .container {
        max-width: none !important;
    }
}
</style>
@endsection