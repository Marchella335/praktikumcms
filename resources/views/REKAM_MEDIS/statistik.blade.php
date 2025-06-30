@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Statistik Rekam Medis</h4>
                    <div>
                        <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Statistik Overview Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Total Rekam Medis</h5>
                                            <h2 class="mb-0">{{ number_format($totalRekamMedis) }}</h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-file-medical fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Hari Ini</h5>
                                            <h2 class="mb-0">{{ number_format($rekamMedisHariIni) }}</h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar-day fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Bulan Ini</h5>
                                            <h2 class="mb-0">{{ number_format($rekamMedisBulanIni) }}</h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart dan Tabel -->
                    <div class="row">
                        <!-- Rekam Medis per Dokter -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Rekam Medis per Dokter (Bulan Ini)</h5>
                                </div>
                                <div class="card-body">
                                    @if($rekamMedisPerDokter->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Dokter</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $no = 1; @endphp
                                                    @foreach($rekamMedisPerDokter as $item)
                                                        @php
                                                            $persentase = $rekamMedisBulanIni > 0 ? ($item->total / $rekamMedisBulanIni) * 100 : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $item->nama_dokter }}</td>
                                                            <td class="text-center">
                                                                <span class="badge badge-primary">{{ $item->total }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                         style="width: {{ $persentase }}%" 
                                                                         aria-valuenow="{{ $persentase }}" 
                                                                         aria-valuemin="0" aria-valuemax="100">
                                                                        {{ number_format($persentase, 1) }}%
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                            <p>Belum ada data rekam medis bulan ini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Rekam Medis Terbaru -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Rekam Medis Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    @if($rekamMedisTerbaru->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Pasien</th>
                                                        <th>Dokter</th>
                                                        <th>Diagnosa</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rekamMedisTerbaru as $item)
                                                        <tr>
                                                            <td>
                                                                <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</small>
                                                            </td>
                                                            <td>
                                                                <small>{{ Str::limit($item->nama_pasien, 15) }}</small>
                                                            </td>
                                                            <td>
                                                                <small>{{ Str::limit($item->nama_dokter, 15) }}</small>
                                                            </td>
                                                            <td>
                                                                <small>{{ Str::limit($item->diagnosa, 20) }}</small>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('rekam_medis.show', $item->id_rekam_medis) }}" 
                                                                   class="btn btn-info btn-xs" title="Lihat Detail">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('rekam_medis.index') }}" class="btn btn-outline-primary btn-sm">
                                                Lihat Semua Rekam Medis
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-file-medical fa-3x mb-3"></i>
                                            <p>Belum ada data rekam medis</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Statistik</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="border rounded p-3 text-center">
                                                <h6 class="text-muted">Rata-rata Rekam Medis/Hari</h6>
                                                @php
                                                    $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                                                    $avgPerDay = $daysInMonth > 0 ? $rekamMedisBulanIni / $daysInMonth : 0;
                                                @endphp
                                                <h4 class="text-primary">{{ number_format($avgPerDay, 1) }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded p-3 text-center">
                                                <h6 class="text-muted">Total Dokter Aktif</h6>
                                                <h4 class="text-success">{{ $rekamMedisPerDokter->count() }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded p-3 text-center">
                                                <h6 class="text-muted">Data Terakhir Update</h6>
                                                <h6 class="text-info">{{ now()->format('d/m/Y H:i') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Aksi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('rekam_medis.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Tambah Rekam Medis
                                        </a>
                                        <a href="{{ route('rekam_medis.search') }}" class="btn btn-info">
                                            <i class="fas fa-search"></i> Cari Rekam Medis
                                        </a>
                                        <a href="{{ route('rekam_medis.export') }}" class="btn btn-success">
                                            <i class="fas fa-download"></i> Export Data
                                        </a>
                                        <button onclick="window.print()" class="btn btn-secondary">
                                            <i class="fas fa-print"></i> Print Statistik
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}

.btn-xs {
    padding: 0.125rem 0.25rem;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 0.125rem;
}

.progress {
    background-color: #e9ecef;
}

.badge-primary {
    background-color: #007bff;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endsection