@extends('layouts.app')

@section('title', 'Detail Dokter - RS Cepat Sembuh')

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
                    <h1 class="h3 mb-1">Detail Dokter</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dokter.index') }}">Dokter</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $dokter->nama_dokter }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <a href="{{ route('dokter.edit', ['id' => $dokter->id_dokter]) }}" class="btn btn-primary">
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
                        <i class="fas fa-user-md me-2"></i>Informasi Dokter
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">ID DOKTER</label>
                                <div class="h6">
                                    <span class="badge bg-light text-dark fs-6">{{ $dokter->id_dokter }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">NAMA DOKTER</label>
                                <div class="h5 mb-0">{{ $dokter->nama_dokter }}</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">SPESIALISASI</label>
                                <div class="h6">
                                    <span class="badge bg-primary fs-6">{{ $dokter->spesialisasi }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">JENIS KELAMIN</label>
                                <div class="h6">
                                    <i class="fas {{ $dokter->jenis_kelamin == 'Laki-laki' ? 'fa-mars text-primary' : 'fa-venus text-danger' }} me-2"></i>
                                    <span>{{ $dokter->jenis_kelamin}}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">NOMOR SIP</label>
                                <div class="h6">
                                    <i class="fas fa-id-card me-2 text-info"></i>
                                    <span>{{ $dokter->nomor_sip }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">JADWAL PRAKTEK</label>
                                <div class="h6">
                                    <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                    <span>{{ $dokter->jadwal_praktek }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">GAJI</label>
                                <div class="h6">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                    <span class="text-success fw-bold">
                                        Rp {{ number_format($dokter->gaji, 0, ',', '.') }}
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
                                <a href="{{ route('dokter.edit', ['id' => $dokter->id_dokter]) }}" 
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
                        <small class="text-muted">Status</small>
                        <div>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Tanggal Bergabung</label>
                        <input type="datetime-local" class="form-control" name="created_at"
                        value="{{ old('created_at', isset($staf->created_at) ? date('Y-m-d\TH:i', strtotime($staf->created_at)) : '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="updated_at" class="form-label">Terakhir Diupdate</label>
                        <input type="datetime-local" class="form-control" name="updated_at"
                        value="{{ old('updated_at', isset($staf->updated_at) ? date('Y-m-d\TH:i', strtotime($staf->updated_at)) : '') }}">
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
                        <a href="{{ route('janji_temu.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu
                        </a>
                        
                        <a href="{{ route('dokter.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-2"></i>Lihat Semua Dokter
                        </a>
                        
                        <a href="{{ route('dokter.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Dokter Baru
                        </a>
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
                <p>Apakah Anda yakin ingin menghapus data dokter berikut?</p>
                <div class="alert alert-light">
                    <strong>Nama:</strong> {{ $dokter->nama_dokter }}<br>
                    <strong>ID:</strong> {{ $dokter->id_dokter }}<br>
                    <strong>Spesialisasi:</strong> {{ $dokter->spesialisasi }}<br>
                    <strong>Nomor SIP:</strong> {{ $dokter->nomor_sip }}
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
                <form action="{{ route('dokter.destroy', ['id' => $dokter->id_dokter]) }}" method="POST" class="d-inline">
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