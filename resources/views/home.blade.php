@extends('layouts.app')

@section('title', 'Dashboard - RS Cepat Sembuh')
@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Dashboard</h1>
                    <p class="text-muted">Selamat datang di Sistem Informasi RS Cepat Sembuh</p>
                </div>
                <div class="text-end">
                    <p class="mb-0 text-muted">{{ date('d F Y') }}</p>
                    <p class="mb-0 text-muted">{{ date('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
<div class="row d-flex flex-wrap justify-content-start mb-4">
    @php
        $stats = [
            ['label' => 'Total Dokter', 'value' => $totalDokter, 'color' => 'primary', 'icon' => 'fas fa-stethoscope'],
            ['label' => 'Total Pasien', 'value' => $totalPasien, 'color' => 'success', 'icon' => 'fas fa-users'],
            ['label' => 'Rekam Medis', 'value' => $totalRekamMedis, 'color' => 'info', 'icon' => 'fas fa-file-medical'],
            ['label' => 'Janji Temu', 'value' => $totalJanjiTemu, 'color' => 'warning', 'icon' => 'fas fa-calendar-check'],
            ['label' => 'Staf', 'value' => $totalStaf, 'color' => 'danger', 'icon' => 'fas fa-user-check'],
        ];
    @endphp

    @foreach ($stats as $stat)
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                {{ $stat['label'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['value'] }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-{{ $stat['color'] }} text-white">
                                <i class="{{ $stat['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $actions = [
                                ['route' => 'pasien.create', 'color' => 'primary', 'icon' => 'fas fa-user-plus', 'label' => 'Daftar Pasien Baru'],
                                ['route' => 'janji_temu.create', 'color' => 'success', 'icon' => 'fas fa-calendar-plus', 'label' => 'Buat Janji Temu'],
                                ['route' => 'rekam_medis.create', 'color' => 'info', 'icon' => 'fas fa-file-medical-alt', 'label' => 'Rekam Medis Baru'],
                                ['route' => 'dokter.create', 'color' => 'warning', 'icon' => 'fas fa-stethoscope', 'label' => 'Tambah Dokter'],
                                ['route' => 'staf.create', 'color' => 'danger', 'icon' => 'fas fa-user', 'label' => 'Tambah Staf'],
                            ];
                        @endphp

                        @foreach ($actions as $action)
                        <div class="col-md-4 col-lg-2">
                            <a href="{{ route($action['route']) }}" class="btn btn-{{ $action['color'] }} w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="{{ $action['icon'] }} fa-2x mb-2"></i>
                                <span class="text-center">{{ $action['label'] }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments and Specializations -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Janji Temu Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($recentAppointments) && $recentAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pasien</th>
                                        <th>Dokter</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAppointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $appointment->TANGGAL_JANJI ? date('d/m/Y', strtotime($appointment->TANGGAL_JANJI)) : '-' }}</span>
                                                <small class="text-muted">{{ $appointment->JAM_JANJI ?? '-' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                                {{ $appointment->pasien->NAMA_PASIEN ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user-md text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $appointment->dokter->NAMA_DOKTER ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $appointment->dokter->SPESIALISASI ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $appointment->KELUHAN ?? '-' }}</td>
                                        <td><span class="badge bg-primary">Terjadwal</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('janji_temu.index') }}" class="btn btn-outline-primary">Lihat Semua Janji Temu</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada janji temu yang terdaftar</p>
                            <a href="{{ route('janji_temu.create') }}" class="btn btn-primary">Buat Janji Temu Pertama</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Spesialisasi Dokter
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($dokterSpesialisasi) && $dokterSpesialisasi->count() > 0)
                        <div class="mb-3">
                            <canvas id="specializationChart" width="400" height="400"></canvas>
                        </div>
                        <div class="mt-3">
                            @foreach($dokterSpesialisasi as $spesialisasi)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">{{ $spesialisasi }}</span>
                                    <small class="text-muted">Tersedia</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data spesialisasi</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- System Info Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $totalStaf ?? 0 }}</h4>
                                <small class="text-muted">Total Staf</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="text-success mb-1">100%</h4>
                            <small class="text-muted">Uptime</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="text-muted mb-0">Database: Oracle</p>
                        <p class="text-muted mb-0">Status: <span class="text-success">Connected</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
@if(isset($dokterSpesialisasi) && $dokterSpesialisasi->count() > 0)
    const ctx = document.getElementById('specializationChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($dokterSpesialisasi->toArray()) !!},
            datasets: [{
                data: {!! json_encode(array_fill(0, $dokterSpesialisasi->count(), 1)) !!},
                backgroundColor: [
                    '#2563eb', '#059669', '#d97706', '#dc2626', '#7c3aed', '#0891b2', '#be185d', '#374151'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
@endif
</script>
@endpush