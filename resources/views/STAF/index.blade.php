@extends('layouts.app')

@section('title', 'Daftar Staf - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Daftar Staf</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Staf</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('staf.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Staf
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

    {{--
    <div class="alert alert-info">
        <h5>DEBUG INFO:</h5>
        <p>Total Data: {{ $staf->count() }}</p>
        <p>Data Type: {{ get_class($staf) }}</p>
        @if($staf->count() > 0)
            @php 
                $first = $staf->first(); 
            @endphp
            <p>First ID: {{ $first->ID_STAF ?? 'NULL' }}</p>
            <p>First Name: {{ $first->NAMA_STAF ?? 'NULL' }}</p>
            <p>Primary Key Name: {{ method_exists($first, 'getKeyName') ? $first->getKeyName() : 'N/A' }}</p>
            <p>Key Value: {{ method_exists($first, 'getKey') ? $first->getKey() : 'N/A' }}</p>
            <p>All Attributes: {{ json_encode(method_exists($first, 'getAttributes') ? $first->getAttributes() : []) }}</p>
        @endif
        
        @if(isset($rawData) && $rawData->count() > 0)
            <hr>
            <h6>Raw Data Sample:</h6>
            <pre>{{ json_encode($rawData->first(), JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
    --}}

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
<div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Staf
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $staf->count() }}</div>
                        </div>
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staf Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user-tie me-2"></i>Data Staf
            </h5>
        </div>
        <div class="card-body">
            @if($staf->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Staf</th>
                                <th>Departemen</th>
                                <th>Nomor Telepon</th>
                                <th>Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staf as $key => $item)
                            <tr>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ID
$id = null;
                                        $possibleIds = ['ID_STAF', 'id_staf', 'Id_Staf', 'id', 'ID'];
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
                                        // Cek semua kemungkinan nama field untuk NAMA
                                        $nama = null;
                                        $possibleNames = ['NAMA_STAF', 'nama_staf', 'Nama_Staf', 'nama', 'NAMA'];
                                        foreach ($possibleNames as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $nama = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="fw-bold">{{ $nama ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk DEPARTEMEN
                                        $dept = null;
                                        $possibleDepts = ['DEPARTEMEN', 'departemen', 'Departemen', 'dept', 'DEPT'];
                                        foreach ($possibleDepts as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $dept = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span class="badge bg-info">{{ $dept ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NOMOR_TELEPON
                                        $telp = null;
                                        $possibleTelps = ['NOMOR_TELEPON', 'nomor_telepon', 'Nomor_Telepon', 'telepon', 'TELEPON', 'phone', 'PHONE'];
                                        foreach ($possibleTelps as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $telp = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        {{ $telp ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk GAJI
                                        $gaji = 0;
                                        $possibleGajis = ['GAJI', 'gaji', 'Gaji', 'salary', 'SALARY'];
                                        foreach ($possibleGajis as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $gaji = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="fw-bold text-success">
                                        Rp {{ number_format($gaji, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    @if($id)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('staf.show', $id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('staf.edit', $id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('staf.destroy', $id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
            @elseif(isset($rawData) && $rawData->count() > 0)
                <!-- Fallback: Tampilkan raw data jika Eloquent gagal -->
                <div class="alert alert-warning">
                    <strong>Mode Fallback:</strong> Menampilkan data mentah karena Eloquent bermasalah.
                </div>
<div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Staf</th>
                                <th>Departemen</th>
                                <th>Nomor Telepon</th>
                                <th>Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rawData as $item)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item->ID_STAF }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->NAMA_STAF }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->DEPARTEMEN }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        {{ $item->NOMOR_TELEPON }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">
                                        Rp {{ number_format($item->GAJI, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staf.show', $item->ID_STAF) }}" 
class="btn btn-sm btn-outline-primary" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staf.edit', $item->ID_STAF) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staf.destroy', $item->ID_STAF) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    <i class="fas fa-user-tie fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Belum ada data staf</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan data staf pertama</p>
                    <a href="{{ route('staf.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Staf Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
