@extends('layouts.app')

@section('title', 'Daftar Rekam Medis - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Daftar Rekam Medis</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Rekam Medis</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('rekam_medis.create') }}" class="btn btn-primary">
                        <i class="fas fa-file-medical me-2"></i>Tambah Rekam Medis
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

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filter & Pencarian
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('rekam_medis.search') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="keyword" class="form-label">Kata Kunci</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="keyword" 
                                   name="keyword" 
                                   placeholder="Nama pasien, dokter, diagnosa..."
                                   value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Dari Tanggal</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date"
                                   value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date"
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dokter_id" class="form-label">Dokter</label>
                            <select class="form-select" id="dokter_id" name="dokter_id">
                                <option value="">Semua Dokter</option>
                                @if(isset($dokters))
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->ID_DOKTER }}" 
                                                {{ request('dokter_id') == $dokter->ID_DOKTER ? 'selected' : '' }}>
                                            {{ $dokter->NAMA_DOKTER }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Rekam Medis
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $rekamMedis->count() }}</div>
                        </div>
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $rekamMedis->where('TANGGAL', date('Y-m-d'))->count() }}</div>
                        </div>
                        <div class="stats-icon bg-success text-white">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Minggu Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                @php
                                    $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
                                    $endOfWeek = \Carbon\Carbon::now()->endOfWeek();
                                    $weeklyCount = $rekamMedis->whereBetween('TANGGAL', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])->count();
                                @endphp
                                {{ $weeklyCount }}
                            </div>
                        </div>
                        <div class="stats-icon bg-info text-white">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                @php
                                    $thisMonth = \Carbon\Carbon::now()->format('Y-m');
                                    $monthlyCount = $rekamMedis->filter(function($item) use ($thisMonth) {
                                        return \Carbon\Carbon::parse($item->tanggal)->format('Y-m') === $thisMonth;
                                    })->count();
                                @endphp
                                {{ $monthlyCount }}
                            </div>
                        </div>
                        <div class="stats-icon bg-warning text-white">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekam Medis Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-medical me-2"></i>Data Rekam Medis
                </h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('rekam_medis.export') }}?format=pdf">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>PDF
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('rekam_medis.export') }}?format=excel">
                            <i class="fas fa-file-excel me-2 text-success"></i>Excel
                        </a></li>
                    </ul>
                </div>
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
                                <th>Tindakan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekamMedis as $key => $item)
                            <tr>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ID
                                        $id = null;
                                        $possibleIds = ['ID_REKAM_MEDIS', 'id_rekam_medis', 'Id_Rekam_Medis', 'id', 'ID'];
                                        foreach ($possibleIds as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $id = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span class="badge bg-light text-dark">RM-{{ str_pad($id ?? 0, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk TANGGAL
                                        $tanggal = null;
                                        $possibleDates = ['TANGGAL', 'tanggal', 'Tanggal', 'date', 'DATE'];
                                        foreach ($possibleDates as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $tanggal = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        <div>
                                            <div class="fw-bold">{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d/m/Y') : 'N/A' }}</div>
                                            <small class="text-muted">{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('H:i') : '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NAMA_PASIEN
                                        $namaPasien = null;
                                        $possibleNames = ['NAMA_PASIEN', 'nama_pasien', 'Nama_Pasien', 'nama', 'NAMA'];
                                        foreach ($possibleNames as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $namaPasien = $item->$fieldName;
                                                break;
                                            }
                                        }
                                        
                                        // Cek ID Pasien
                                        $idPasien = null;
                                        $possiblePasienIds = ['ID_PASIEN', 'id_pasien', 'Id_Pasien'];
                                        foreach ($possiblePasienIds as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $idPasien = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $namaPasien ?? 'N/A' }}</div>
                                            <small class="text-muted">ID: {{ $idPasien ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NAMA_DOKTER
                                        $namaDokter = null;
                                        $possibleDoctors = ['NAMA_DOKTER', 'nama_dokter', 'Nama_Dokter'];
                                        foreach ($possibleDoctors as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $namaDokter = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-md text-white"></i>
                                        </div>
                                        <div class="fw-bold">{{ $namaDokter ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk DIAGNOSA
                                        $diagnosa = null;
                                        $possibleDiagnosa = ['DIAGNOSA', 'diagnosa', 'Diagnosa', 'diagnosis', 'DIAGNOSIS'];
                                        foreach ($possibleDiagnosa as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $diagnosa = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $diagnosa ?? 'N/A' }}">
                                        <i class="fas fa-stethoscope me-2 text-muted"></i>
                                        {{ $diagnosa ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk TINDAKAN
                                        $tindakan = null;
                                        $possibleTindakan = ['TINDAKAN', 'tindakan', 'Tindakan', 'treatment', 'TREATMENT'];
                                        foreach ($possibleTindakan as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $tindakan = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="text-truncate" style="max-width: 180px;" title="{{ $tindakan ?? 'N/A' }}">
                                        <i class="fas fa-procedures me-2 text-muted"></i>
                                        {{ $tindakan ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $isRecent = $tanggal && \Carbon\Carbon::parse($tanggal)->isToday();
                                        $isThisWeek = $tanggal && \Carbon\Carbon::parse($tanggal)->isCurrentWeek();
                                    @endphp
                                    @if($isRecent)
                                        <span class="badge bg-success">
                                            <i class="fas fa-clock me-1"></i>
                                            Hari Ini
                                        </span>
                                    @elseif($isThisWeek)
                                        <span class="badge bg-info">
                                            <i class="fas fa-calendar-week me-1"></i>
                                            Minggu Ini
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-archive me-1"></i>
                                            Arsip
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($id)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('rekam_medis.show', $id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rekam_medis.edit', $id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('rekam_medis.destroy', $id) }}" 
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
                                    @else
                                        <span class="text-danger">NO ID</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-medical fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Belum ada data rekam medis</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan rekam medis pertama</p>
                    <a href="{{ route('rekam_medis.create') }}" class="btn btn-primary">
                        <i class="fas fa-file-medical me-2"></i>Tambah Rekam Medis Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x text-primary mb-2"></i>
                    <h6 class="card-title">Statistik</h6>
                    <p class="card-text small">Lihat statistik rekam medis</p>
                    <a href="{{ route('rekam_medis.statistik') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-line me-1"></i>Lihat Statistik
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-search fa-2x text-success mb-2"></i>
                    <h6 class="card-title">Pencarian Lanjut</h6>
                    <p class="card-text small">Cari rekam medis dengan filter detail</p>
                    <a href="{{ route('rekam_medis.search') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-search me-1"></i>Pencarian Lanjut
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-download fa-2x text-warning mb-2"></i>
                    <h6 class="card-title">Export Data</h6>
                    <p class="card-text small">Download data rekam medis</p>
                    <a href="{{ route('rekam_medis.export') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-download me-1"></i>Export Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

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

.card.border-primary {
    border-color: #4e73df !important;
}

.card.border-success {
    border-color: #1cc88a !important;
}

.card.border-warning {
    border-color: #f6c23e !important;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #5a5c69;
}
</style>
@endsection