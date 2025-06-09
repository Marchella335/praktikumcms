@extends('layouts.app')

@section('title', 'Detail Janji Temu - RS Cepat Sembuh')

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
                    <h1 class="h3 mb-1">Detail Janji Temu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('janji_temu.index') }}">Janji Temu</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $janjiTemu->nama_pasien }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('janji_temu.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <a href="{{ route('janji_temu.edit', ['id' => $janjiTemu->id_janji]) }}" class="btn btn-primary">
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
                        <i class="fas fa-calendar-check me-2"></i>Informasi Janji Temu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">ID JANJI TEMU</label>
                                <div class="h6">
                                    <span class="badge bg-light text-dark fs-6">{{ $janjiTemu->id_janji }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">NAMA PASIEN</label>
                                <div class="h5 mb-0">
                                    <a href="{{ route('pasien.show', ['id' => $janjiTemu->id_pasien]) }}" class="text-decoration-none">
                                        {{ $janjiTemu->nama_pasien }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">DOKTER</label>
                                <div class="h6">
                                    <i class="fas fa-user-md me-2 text-primary"></i>
                                    <span>{{ $janjiTemu->nama_dokter }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">SPESIALISASI</label>
                                <div class="h6">
                                    <i class="fas fa-stethoscope me-2 text-info"></i>
                                    <span>{{ $janjiTemu->spesialisasi }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">TANGGAL JANJI</label>
                                <div class="h6">
                                    <i class="fas fa-calendar me-2 text-warning"></i>
                                    <span>{{ Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">JAM JANJI</label>
                                <div class="h6">
                                    <i class="fas fa-clock me-2 text-success"></i>
                                    <span>{{ Carbon::parse($janjiTemu->jam_janji)->format('H:i') }} WIB</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">NOMOR TELEPON PASIEN</label>
                                <div class="h6">
                                    <i class="fas fa-phone me-2 text-info"></i>
                                    <span>{{ $janjiTemu->nomor_telepon }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">STATUS JANJI</label>
                                <div class="h6">
                                    @php
                                        $tanggalJanji = Carbon::parse($janjiTemu->tanggal_janji);
                                        $isToday = $tanggalJanji->isToday();
                                        $isUpcoming = $tanggalJanji->isFuture();
                                        $isPast = $tanggalJanji->isPast();
                                    @endphp
                                    <span class="badge 
                                        @if($isToday) bg-warning
                                        @elseif($isUpcoming) bg-info
                                        @elseif($isPast) bg-success
                                        @else bg-secondary
                                        @endif fs-6">
                                        @if($isToday) Hari Ini
                                        @elseif($isUpcoming) Akan Datang
                                        @elseif($isPast) Selesai
                                        @else Tidak Diketahui
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keluhan Section -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="mb-4">
                                <label class="form-label text-muted small">keluhan</label>
                                <div class="border rounded p-3 bg-light">
                                    <p class="mb-0">{{ $janjiTemu->keluhan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons in Card -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('janji_temu.edit', ['id' => $janjiTemu->id_janji]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Janji
                                </a>
                                
                                <button type="button" class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Hapus Janji
                                </button>

                                <a href="{{ route('pasien.show', ['id' => $janjiTemu->id_pasien]) }}" 
                                   class="btn btn-outline-info">
                                    <i class="fas fa-user me-2"></i>Lihat Pasien
                                </a>
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
                        <small class="text-muted">Status Janji</small>
                        <div>
                            @php
                                $tanggalJanji = Carbon::parse($janjiTemu->tanggal_janji);
                                $isToday = $tanggalJanji->isToday();
                                $isUpcoming = $tanggalJanji->isFuture();
                                $isPast = $tanggalJanji->isPast();
                            @endphp
                            <span class="badge 
                                @if($isToday) bg-warning
                                @elseif($isUpcoming) bg-info
                                @elseif($isPast) bg-success
                                @else bg-secondary
                                @endif">
                                @if($isToday) Hari Ini
                                @elseif($isUpcoming) Akan Datang
                                @elseif($isPast) Selesai
                                @else Tidak Diketahui
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Waktu Lengkap</small>
                         <div>
                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                            {{ \Carbon\Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y H:i') }} WIB
                        </div>
                    </div>

                    @if($isUpcoming)
                    <div class="mb-3">
                        <small class="text-muted">Sisa Waktu</small>
                        <div class="text-sm">
                            <i class="fas fa-hourglass-half text-warning me-1"></i>
                            {{ $tanggalJanji->diffForHumans() }}
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Kontak Pasien</small>
                        <div class="text-sm">
                            <i class="fas fa-phone text-success me-1"></i>
                            <a href="tel:{{ $janjiTemu->nomor_telepon }}" class="text-decoration-none">
                                {{ $janjiTemu->nomor_telepon }}
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
                        <a href="{{ route('janji_temu.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu Baru
                        </a>
                        
                        <a href="{{ route('pasien.show', ['id' => $janjiTemu->id_pasien]) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-user me-2"></i>Detail Pasien
                        </a>
                        
                        <a href="{{ route('janji_temu.by_pasien', ['idPasien' => $janjiTemu->id_pasien]) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-history me-2"></i>Riwayat Janji Pasien
                        </a>
                        
                        <a href="{{ route('janji_temu.by_dokter', ['idDokter' => $janjiTemu->id_dokter]) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-user-md me-2"></i>Jadwal Dokter
                        </a>
                        
                        <a href="{{ route('janji_temu.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-2"></i>Semua Janji Temu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointment Summary Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Ringkasan Waktu
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 text-primary mb-0">
                                    {{ Carbon::parse($janjiTemu->tanggal_janji)->format('d') }}
                                </div>
                                <small class="text-muted">Tanggal</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 text-warning mb-0">
                                    {{ Carbon::parse($janjiTemu->tanggal_janji)->format('M') }}
                                </div>
                                <small class="text-muted">Bulan</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="h5 text-success mb-0">
                                {{ Carbon::parse($janjiTemu->jam_janji)->format('H:i') }}
                            </div>
                            <small class="text-muted">Jam</small>
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
                <p>Apakah Anda yakin ingin menghapus janji temu berikut?</p>
                <div class="alert alert-light">
                    <strong>ID Janji:</strong> {{ $janjiTemu->id_janji }}<br>
                    <strong>Pasien:</strong> {{ $janjiTemu->nama_pasien }}<br>
                    <strong>Dokter:</strong> {{ $janjiTemu->nama_dokter }}<br>
                    <strong>Tanggal:</strong> {{ Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y') }}<br>
                    <strong>Jam:</strong> {{ Carbon::parse($janjiTemu->jam_janji)->format('H:i') }} WIB<br>
                    <strong>Keluhan:</strong> {{ Str::limit($janjiTemu->keluhan, 50) }}
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
                <form action="{{ route('janji_temu.destroy', ['id' => $janjiTemu->id_janji]) }}" method="POST" class="d-inline">
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