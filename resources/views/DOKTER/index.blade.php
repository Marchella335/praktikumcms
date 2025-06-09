@extends('layouts.app')

@section('title', 'Daftar Dokter - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Daftar Dokter</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Dokter</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('dokter.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-md me-2"></i>Tambah Dokter
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
                                Total Dokter
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $dokter->count() }}</div>
                        </div>
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-stethoscope"></i>
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
                                Spesialisasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $dokter->pluck('SPESIALISASI')->unique()->count() }}</div>
                        </div>
                        <div class="stats-icon bg-success text-white">
                            <i class="fas fa-medical-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokter Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-stethoscope me-2"></i>Data Dokter
            </h5>
        </div>
        <div class="card-body">
            @if($dokter->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Dokter</th>
                                <th>Spesialisasi</th>
                                <th>Nomor SIP</th>
                                <th>Jadwal Praktek</th>
                                <th>Jenis Kelamin</th>
                                <th>Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokter as $key => $item)
                            <tr>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk ID
                                        $id = null;
                                        $possibleIds = ['ID_DOKTER', 'id_dokter', 'Id_Dokter', 'id', 'ID'];
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
                                        // Cek semua kemungkinan nama field untuk NAMA_DOKTER
                                        $nama = null;
                                        $possibleNames = ['NAMA_DOKTER', 'nama_dokter', 'Nama_Dokter', 'nama', 'NAMA'];
                                        foreach ($possibleNames as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $nama = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-md text-white"></i>
                                        </div>
                                        <div class="fw-bold">{{ $nama ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk SPESIALISASI
                                        $spesialisasi = null;
                                        $possibleSpecs = ['SPESIALISASI', 'spesialisasi', 'Spesialisasi', 'spec', 'SPEC'];
                                        foreach ($possibleSpecs as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $spesialisasi = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span class="badge bg-info">{{ $spesialisasi ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk NOMOR_SIP
                                        $sip = null;
                                        $possibleSips = ['NOMOR_SIP', 'nomor_sip', 'Nomor_Sip', 'sip', 'SIP'];
                                        foreach ($possibleSips as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $sip = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-id-card me-2 text-muted"></i>
                                        {{ $sip ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        // Cek semua kemungkinan nama field untuk JADWAL_PRAKTEK
                                        $jadwal = null;
                                        $possibleSchedules = ['JADWAL_PRAKTEK', 'jadwal_praktek', 'Jadwal_Praktek', 'jadwal', 'JADWAL'];
                                        foreach ($possibleSchedules as $fieldName) {
                                            if (isset($item->$fieldName)) {
                                                $jadwal = $item->$fieldName;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        {{ $jadwal ?? 'N/A' }}
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
                                            <a href="{{ route('dokter.show', $id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dokter.edit', $id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dokter.destroy', $id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Yakin ingin menghapus data dokter ini?')">
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
                    <i class="fas fa-stethoscope fa-5x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">Belum ada data dokter</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan data dokter pertama</p>
                    <a href="{{ route('dokter.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-md me-2"></i>Tambah Dokter Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection