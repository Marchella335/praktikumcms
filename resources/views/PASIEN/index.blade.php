@extends('layouts.app')

@section('title', 'Daftar Pasien - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Daftar Pasien</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Pasien</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pasien
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
                                Total Pasien
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $pasien->count() }}</div>
                        </div>

                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-users"></i>
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
                                Laki-laki
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $pasien->where('JENIS_KELAMIN', 'Laki-laki')->count() }}</div>
                        </div>
                        <div class="stats-icon bg-success text-white">
                            <i class="fas fa-mars"></i>
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
                                Perempuan
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $pasien->where('JENIS_KELAMIN', 'Perempuan')->count() }}</div>
                        </div>
                        <div class="stats-icon bg-info text-white">
                            <i class="fas fa-venus"></i>
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
                                Rata-rata Usia
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $pasien->avg('USIA') ? round($pasien->avg('USIA'), 1) : 0 }} tahun</div>
                        </div>
                        <div class="stats-icon bg-warning text-white">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pasien Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i>Data Pasien
            </h5>
        </div>
        <div class="card-body">
            @if($pasien->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pasien</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Usia</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasien as $key => $item)
                            <tr>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ID
                                        $id = null;
                                        $possibleIds = ['ID_PASIEN', 'id_pasien', 'Id_Pasien', 'id', 'ID'];
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
                                        $nama = null;
                                        $possibleNames = ['NAMA_PASIEN', 'nama_pasien', 'Nama_Pasien', 'nama', 'NAMA'];
                                        foreach ($possibleNames as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $nama = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div class="fw-bold">{{ $nama ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ALAMAT
                                        $alamat = null;
                                        $possibleAlamat = ['ALAMAT', 'alamat', 'Alamat', 'address', 'ADDRESS'];
                                        foreach ($possibleAlamat as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $alamat = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $alamat ?? 'N/A' }}">
                                            {{ $alamat ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NOMOR_TELEPON
                                        $telepon = null;
                                        $possibleTelepon = ['NOMOR_TELEPON', 'nomor_telepon', 'Nomor_Telepon', 'phone', 'PHONE'];
                                        foreach ($possibleTelepon as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $telepon = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        {{ $telepon ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk USIA
                                        $usia = null;
                                        $possibleUsia = ['USIA', 'usia', 'Usia', 'age', 'AGE'];
                                        foreach ($possibleUsia as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $usia = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-birthday-cake me-2 text-muted"></i>
                                        <span class="badge bg-secondary">{{ $usia ?? 0 }} tahun</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk JENIS_KELAMIN
                                        $gender = null;
                                        $possibleGenders = ['JENIS_KELAMIN', 'jenis_kelamin', 'Jenis_Kelamin', 'gender', 'GENDER'];
                                        foreach ($possibleGenders as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $gender = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if($gender)
                                        <span class="badge {{ $gender == 'Laki-laki' ? 'bg-primary' : 'bg-success' }}">
                                            <i class="fas fa-{{ $gender == 'Laki-laki' ? 'mars' : 'venus' }} me-1"></i>
                                            {{ $gender }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk STATUS_PASIEN
                                        $status = null;
                                        $possibleStatus = ['STATUS_PASIEN', 'status_pasien', 'Status_Pasien', 'status', 'STATUS'];
                                        foreach ($possibleStatus as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $status = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if($status)
                                        @php
                                            $statusClass = '';
                                            $statusIcon = 'fas fa-info-circle';
                                            
                                            if (stripos($status, 'rawat') !== false) {
                                                $statusClass = 'bg-warning';
                                                $statusIcon = 'fas fa-hospital';
                                            } elseif (stripos($status, 'selesai') !== false || stripos($status, 'sembuh') !== false) {
                                                $statusClass = 'bg-success';
                                                $statusIcon = 'fas fa-check-circle';
                                            } elseif (stripos($status, 'aktif') !== false) {
                                                $statusClass = 'bg-info';
                                                $statusIcon = 'fas fa-user-check';
                                            } else {
                                                $statusClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            <i class="{{ $statusIcon }} me-1"></i>
                                            {{ $status }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($id)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pasien.show', $id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pasien.edit', $id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pasien.destroy', $id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Yakin ingin menghapus data pasien ini?')">
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
                    <i class="fas fa-users fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Belum ada data pasien</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan data pasien pertama</p>
                    <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pasien Pertama
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
</style>
@endsection