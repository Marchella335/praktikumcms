@extends('layouts.app')

@section('title', 'Daftar Janji Temu - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Daftar Janji Temu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Janji Temu</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('janji_temu.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i>Tambah Janji Temu
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Janji Temu
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $janjiTemu->count() }}</div>
                        </div>
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-calendar-alt"></i>
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
                            <div class="h5 mb-0 font-weight-bold">{{ $janjiTemu->where('TANGGAL_JANJI', now()->format('Y-m-d'))->count() }}</div>
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
                                Akan Datang
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $janjiTemu->where('TANGGAL_JANJI', '>', now()->format('Y-m-d'))->count() }}</div>
                        </div>
                        <div class="stats-icon bg-info text-white">
                            <i class="fas fa-clock"></i>
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
                                Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $janjiTemu->where('TANGGAL_JANJI', '<', now()->format('Y-m-d'))->count() }}</div>
                        </div>
                        <div class="stats-icon bg-warning text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Janji Temu Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Data Janji Temu
            </h5>
        </div>
        <div class="card-body">
            @if($janjiTemu->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Janji</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($janjiTemu as $key => $item)
                            <tr>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ID_JANJI
                                        $id = null;
                                        $possibleIds = ['ID_JANJI', 'id_janji', 'Id_Janji', 'id', 'ID'];
                                        foreach ($possibleIds as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $id = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span class="badge bg-light text-dark">{{ $id ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NAMA_PASIEN
                                        $namaPasien = null;
                                        $possibleNames = ['NAMA_PASIEN', 'nama_pasien', 'Nama_Pasien', 'pasien_nama', 'nama'];
                                        foreach ($possibleNames as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $namaPasien = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div class="fw-bold">{{ $namaPasien ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NAMA_DOKTER
                                        $namaDokter = null;
                                        $possibleDoctors = ['NAMA_DOKTER', 'nama_dokter', 'Nama_Dokter', 'dokter_nama', 'nama'];
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
                                        // Cek semua kemungkinan nama field untuk TANGGAL_JANJI
                                        $tanggal = null;
                                        $possibleDates = ['TANGGAL_JANJI', 'tanggal_janji', 'Tanggal_Janji', 'tanggal', 'date'];
                                        foreach ($possibleDates as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $tanggal = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        @if($tanggal)
                                            <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk JAM_JANJI
                                        $jam = null;
                                        $possibleTimes = ['JAM_JANJI', 'jam_janji', 'Jam_Janji', 'jam', 'time'];
                                        foreach ($possibleTimes as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $jam = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock me-2 text-muted"></i>
                                        @if($jam)
                                            <span class="badge bg-secondary">{{ \Carbon\Carbon::parse($jam)->format('H:i') }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk KELUHAN
                                        $keluhan = null;
                                        $possibleComplaints = ['KELUHAN', 'keluhan', 'Keluhan', 'complaint', 'keterangan'];
                                        foreach ($possibleComplaints as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $keluhan = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $keluhan ?? 'N/A' }}">
                                        {{ $keluhan ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = '';
                                        $statusIcon = '';
                                        $statusText = '';
                                        
                                        if($tanggal) {
                                            $tanggalJanji = \Carbon\Carbon::parse($tanggal);
                                            $today = \Carbon\Carbon::today();
                                            
                                            if ($tanggalJanji->isToday()) {
                                                $statusClass = 'bg-success';
                                                $statusIcon = 'fas fa-calendar-day';
                                                $statusText = 'Hari Ini';
                                            } elseif ($tanggalJanji->isFuture()) {
                                                $statusClass = 'bg-info';
                                                $statusIcon = 'fas fa-clock';
                                                $statusText = 'Akan Datang';
                                            } else {
                                                $statusClass = 'bg-warning';
                                                $statusIcon = 'fas fa-check-circle';
                                                $statusText = 'Selesai';
                                            }
                                        } else {
                                            $statusClass = 'bg-secondary';
                                            $statusIcon = 'fas fa-question-circle';
                                            $statusText = 'N/A';
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }} me-1"></i>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>
                                    @if($id)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('janji_temu.show', $id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('janji_temu.edit', $id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('janji_temu.destroy', $id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Yakin ingin menghapus janji temu ini?')">
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
                    <i class="fas fa-calendar-alt fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Belum ada janji temu</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan janji temu pertama</p>
                    <a href="{{ route('janji_temu.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i>Tambah Janji Temu Pertama
                    </a>
                </div>
            @endif
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

/* Additional styles for appointment status */
.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.badge i {
    font-size: 0.7rem;
}

/* Custom colors for different appointment statuses */
.bg-success {
    background-color: #28a745 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.bg-secondary {
    background-color: #6c757d !important;
}

.bg-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
}
</style>
@endsection