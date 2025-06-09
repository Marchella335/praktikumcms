@extends('layouts.app')

@section('title', 'Detail Pasien - RS Cepat Sembuh')

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
                    <h1 class="h3 mb-1">Detail Pasien</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pasien.index') }}">Pasien</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $pasien->nama_pasien }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <a href="{{ route('pasien.edit', ['id' => $pasien->id_pasien]) }}" class="btn btn-primary">
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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-injured me-2"></i>Informasi Pasien
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">ID PASIEN</label>
                                <div class="h6">
                                    <span class="badge bg-light text-dark fs-6">{{ $pasien->id_pasien }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">NAMA PASIEN</label>
                                <div class="h5 mb-0">{{ $pasien->nama_pasien }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">JENIS KELAMIN</label>
                                <div class="h6">
                                    <i class="fas {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'fa-mars text-primary' : 'fa-venus text-danger' }} me-2"></i>
                                    <span>{{ $pasien->jenis_kelamin }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">USIA</label>
                                <div class="h6">
                                    <i class="fas fa-birthday-cake me-2 text-warning"></i>
                                    <span>{{ $pasien->usia}} Tahun</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">NOMOR TELEPON</label>
                                <div class="h6">
                                    <i class="fas fa-phone me-2 text-info"></i>
                                    <span>{{ $pasien->nomor_telepon }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">ALAMAT</label>
                                <div class="h6">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    <span>{{ $pasien->alamat }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">STATUS PASIEN</label>
                                <div class="h6">
                                    <span class="badge 
                                        @if(strtolower($pasien->status_pasien) == 'rawat inap') bg-warning
                                        @elseif(strtolower($pasien->status_pasien) == 'rawat jalan') bg-info
                                        @elseif(strtolower($pasien->status_pasien) == 'sembuh') bg-success
                                        @elseif(strtolower($pasien->status_pasien) == 'rujuk') bg-danger
                                        @else bg-secondary
                                        @endif fs-6">
                                        {{ $pasien->status_pasien }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons in Card -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('pasien.edit', ['id' => $pasien->id_pasien]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Data
                                </a>
                                
                                <button type="button" class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Hapus Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Side Info Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status Aktif</small>
                        <div>
                            <span class="badge 
                                @if(strtolower($pasien->status_pasien) == 'rawat inap') bg-warning
                                @elseif(strtolower($pasien->status_pasien) == 'rawat jalan') bg-info
                                @elseif(strtolower($pasien->status_pasien) == 'sembuh') bg-success
                                @elseif(strtolower($pasien->status_pasien) == 'rujuk') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $pasien->status_pasien }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Kategori Usia</small>
                        <div>
                            @if($pasien->usia < 12)
                                <span class="badge bg-info">Anak</span>
                            @elseif($pasien->usia < 18)
                                <span class="badge bg-primary">Remaja</span>
                            @elseif($pasien->usia < 60)
                                <span class="badge bg-success">Dewasa</span>
                            @else
                                <span class="badge bg-warning">Lansia</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Kontak Darurat</small>
                        <div class="text-sm">
                            <i class="fas fa-phone text-success me-1"></i>
                            <a href="tel:{{ $pasien->nomor_telepon }}" class="text-decoration-none">
                                {{ $pasien->nomor_telepon}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('janji_temu.create') }}?pasien_id={{ $pasien->id_pasien }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu
                        </a>
                        
                        <a href="#" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-file-medical me-2"></i>Lihat Rekam Medis
                        </a>
                        
                        <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-2"></i>Lihat Semua Pasien
                        </a>
                        
                        <a href="{{ route('pasien.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Pasien Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Medical Summary Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-heartbeat me-2"></i>Ringkasan Medis
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 text-primary mb-0">0</div>
                                <small class="text-muted">Kunjungan</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 text-warning mb-0">0</div>
                                <small class="text-muted">Janji Temu</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="h5 text-success mb-0">0</div>
                            <small class="text-muted">Resep</small>
                        </div>
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
                <p>Apakah Anda yakin ingin menghapus data pasien berikut?</p>
                <div class="alert alert-light">
                    <strong>Nama:</strong> {{ $pasien->nama_pasien }}<br>
                    <strong>ID:</strong> {{ $pasien->id_pasien }}<br>
                    <strong>Usia:</strong> {{ $pasien->usia }} Tahun<br>
                    <strong>Telepon:</strong> {{ $pasien->nomor_telepon }}<br>
                    <strong>Status:</strong> {{ $pasien->status_pasien }}
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
                <form action="{{ route('pasien.destroy', ['id' => $pasien->id_pasien]) }}" method="POST" class="d-inline">
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
@endsection