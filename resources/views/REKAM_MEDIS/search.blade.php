@extends('layouts.app')

@section('title', 'Pencarian Rekam Medis - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Pencarian Rekam Medis</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('rekam_medis.index') }}">Rekam Medis</a>
                            </li>
                            <li class="breadcrumb-item active">Pencarian</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
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

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-search me-2"></i>Form Pencarian
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('rekam_medis.search') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="keyword" class="form-label">Kata Kunci</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="keyword" 
                                   name="keyword" 
                                   placeholder="Nama pasien, dokter, diagnosa, hasil pemeriksaan..."
                                   value="{{ request('keyword') }}">
                            <div class="form-text">Masukkan kata kunci untuk mencari di nama pasien, dokter, diagnosa, atau hasil pemeriksaan</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label">Dari Tanggal</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date"
                                   value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date"
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="dokter_id" class="form-label">Pilih Dokter</label>
                            <select class="form-select" id="dokter_id" name="dokter_id">
                                <option value="">-- Semua Dokter --</option>
                                @if(isset($dokters) && $dokters->count() > 0)
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id_dokter }}" 
                                                {{ request('dokter_id') == $dokter->id_dokter ? 'selected' : '' }}>
                                            {{ $dokter->nama_dokter }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="pasien_id" class="form-label">Pilih Pasien</label>
                            <select class="form-select" id="pasien_id" name="pasien_id">
                                <option value="">-- Semua Pasien --</option>
                                @if(isset($pasiens) && $pasiens->count() > 0)
                                    @foreach($pasiens as $pasien)
                                        <option value="{{ $pasien->id_pasien }}" 
                                                {{ request('pasien_id') == $pasien->id_pasien ? 'selected' : '' }}>
                                            {{ $pasien->nama_pasien }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            <a href="{{ route('rekam_medis.search') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    @if(isset($rekamMedis))
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Hasil Pencarian
                        <span class="badge bg-primary ms-2">{{ $rekamMedis->count() }} data</span>
                    </h5>
                    @if($rekamMedis->count() > 0)
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('rekam_medis.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">
                                    <i class="fas fa-file-pdf me-2 text-danger"></i>Export ke PDF
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('rekam_medis.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() . '&format=excel' : '?format=excel' }}">
                                    <i class="fas fa-file-excel me-2 text-success"></i>Export ke Excel
                                </a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($rekamMedis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Diagnosa</th>
                                    <th>Hasil Pemeriksaan</th>
                                    <th>Tindakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekamMedis as $item)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            RM-{{ str_pad($item->ID_REKAM_MEDIS ?? 0, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            <div>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $item->nama_pasien }}</div>
                                                <small class="text-muted">ID: {{ $item->id_pasien }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                            <div class="fw-bold">{{ $item->nama_dokter }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $item->diagnosa }}">
                                            <i class="fas fa-stethoscope me-2 text-muted"></i>
                                            {{ $item->diagnosa }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="{{ $item->hasil_pemeriksaan }}">
                                            <i class="fas fa-notes-medical me-2 text-muted"></i>
                                            {{ $item->hasil_pemeriksaan }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 180px;" title="{{ $item->tindakan }}">
                                            <i class="fas fa-procedures me-2 text-muted"></i>
                                            {{ $item->tindakan }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('rekam_medis.show', $item->id_rekam_medis) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rekam_medis.edit', $item->id_rekam_medis) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('rekam_medis.destroy', $item->id_rekam_medis) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-5x text-muted mb-3"></i>
                        <h5 class="text-muted mb-3">Tidak ada data yang ditemukan</h5>
                        <p class="text-muted mb-4">Coba ubah kriteria pencarian Anda</p>
                        <a href="{{ route('rekam_medis.search') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Cari Lagi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Initial State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-5x text-muted mb-3"></i>
                <h5 class="text-muted mb-3">Pencarian Rekam Medis</h5>
                <p class="text-muted mb-4">Gunakan form di atas untuk mencari rekam medis berdasarkan kriteria yang Anda inginkan</p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <i class="fas fa-search fa-2x text-primary mb-2"></i>
                                        <h6>Pencarian Kata Kunci</h6>
                                        <p class="small text-muted">Cari berdasarkan nama pasien, dokter, atau diagnosa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                                        <h6>Filter Tanggal</h6>
                                        <p class="small text-muted">Batasi pencarian berdasarkan rentang tanggal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.avatar-sm {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
}

.text-truncate {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
    background-color: #f8f9fc;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #5a5c69;
}

.card.border-primary {
    border-color: #4e73df !important;
}

.card.border-success {
    border-color: #1cc88a !important;
}
</style>
@endsection