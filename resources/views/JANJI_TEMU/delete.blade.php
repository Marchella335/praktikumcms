@extends('layouts.app')

@section('title', 'Hapus Janji Temu - RS Cepat Sembuh')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Penghapusan Data Janji Temu
                    </h3>
                </div>

                <div class="card-body">
                    {{-- Alert Messages --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Warning Message --}}
                    <div class="alert alert-warning border-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                            <div>
                                <h5 class="mb-1">Peringatan!</h5>
                                <p class="mb-0">Anda akan menghapus data janji temu secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Appointment Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Data Janji Temu yang akan dihapus:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>ID Janji Temu:</strong></td>
                                            <td>
                                                <span class="badge bg-secondary fs-6">{{ $janjiTemu->ID_JANJI }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal:</strong></td>
                                            <td>
                                                <span class="text-primary fw-bold">
                                                    {{ \Carbon\Carbon::parse($janjiTemu->TANGGAL_JANJI)->format('d F Y') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Waktu:</strong></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ \Carbon\Carbon::parse($janjiTemu->JAM_JANJI)->format('H:i') }} WIB
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @php
                                                    $status = $janjiTemu->status;
                                                    $statusClass = match($status) {
                                                        'Akan Datang' => 'bg-warning text-dark',
                                                        'Selesai' => 'bg-success',
                                                        'Hari Ini' => 'bg-primary',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Nama Pasien:</strong></td>
                                            <td>
                                                <span class="text-success fw-bold">{{ $janjiTemu->pasien->NAMA_PASIEN ?? 'Tidak diketahui' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Dokter:</strong></td>
                                            <td>
                                                <span class="text-info fw-bold">{{ $janjiTemu->dokter->NAMA_DOKTER ?? 'Tidak diketahui' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Spesialisasi:</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $janjiTemu->dokter->SPESIALISASI ?? '-' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Keluhan:</strong></td>
                                            <td class="text-muted">
                                                @if($janjiTemu->KELUHAN)
                                                    {{ Str::limit($janjiTemu->KELUHAN, 50) }}
                                                    @if(strlen($janjiTemu->KELUHAN) > 50)
                                                        <span class="text-primary" data-bs-toggle="tooltip" title="{{ $janjiTemu->KELUHAN }}">
                                                            (lihat selengkapnya)
                                                        </span>
                                                    @endif
                                                @else
                                                    <em>Tidak ada keluhan</em>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Impact Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Dampak Penghapusan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-danger"><i class="fas fa-times-circle"></i> Yang akan hilang:</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Data janji temu akan dihapus dari sistem</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Tidak dapat dikembalikan setelah dikonfirmasi</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Riwayat jadwal konsultasi</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Catatan keluhan pasien (jika ada)</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Relasi data dengan rekam medis</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success"><i class="fas fa-check-circle"></i> Yang tetap aman:</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Data pasien tidak terpengaruh</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Data dokter tetap aman</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Janji temu lain tidak terpengaruh</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Sistem akan tetap berjalan normal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Warning for Active Appointments --}}
                    @if($janjiTemu->status === 'Hari Ini' || $janjiTemu->status === 'Akan Datang')
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fa-2x text-danger me-3"></i>
                            <div>
                                <h6 class="mb-1">Perhatian Khusus!</h6>
                                <p class="mb-0">Janji temu ini memiliki status <strong>{{ $janjiTemu->status }}</strong>. 
                                @if($janjiTemu->status === 'Akan Datang')
                                    Pastikan pasien telah diberitahu tentang pembatalan jadwal.
                                @elseif($janjiTemu->status === 'Hari Ini')
                                    Konsultasi dijadwalkan hari ini. Pastikan tidak ada gangguan pada proses medis.
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Future Appointment Warning --}}
                    @if($janjiTemu->isUpcoming())
                    <div class="alert alert-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-check fa-2x text-warning me-3"></i>
                            <div>
                                <h6 class="mb-1">Janji Temu Mendatang!</h6>
                                <p class="mb-0">Janji temu ini dijadwalkan untuk masa depan 
                                    (<strong>{{ $janjiTemu->days_until_appointment > 0 ? $janjiTemu->days_until_appointment . ' hari lagi' : 'hari ini' }}</strong>). 
                                    Pastikan pasien dan dokter telah diberitahu tentang pembatalan ini.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Confirmation Checkbox --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label text-danger fw-bold" for="confirmDelete">
                            Saya memahami bahwa tindakan ini tidak dapat dibatalkan dan akan menghapus semua data janji temu secara permanen
                        </label>
                    </div>

                    {{-- Confirmation Form --}}
                    <form action="{{ route('janji-temu.destroy', $janjiTemu->ID_JANJI) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('janji-temu.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-danger btn-lg" id="deleteButton" disabled>
                                <i class="fas fa-trash-alt me-2"></i>Hapus Permanen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable delete button only when checkbox is checked
    document.getElementById('confirmDelete').addEventListener('change', function() {
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = !this.checked;
        
        if (this.checked) {
            deleteButton.classList.remove('btn-secondary');
            deleteButton.classList.add('btn-danger');
        } else {
            deleteButton.classList.remove('btn-danger');
            deleteButton.classList.add('btn-secondary');
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Confirmation dialog
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        const tanggalJanji = '{{ \Carbon\Carbon::parse($janjiTemu->TANGGAL_JANJI)->format("d F Y") }}';
        const namaPasien = '{{ $janjiTemu->pasien->NAMA_PASIEN ?? "Pasien" }}';
        const namaDokter = '{{ $janjiTemu->dokter->NAMA_DOKTER ?? "Dokter" }}';
        
        const confirmMessage = `Apakah Anda benar-benar yakin ingin menghapus janji temu?\n\n` +
                              `Tanggal: ${tanggalJanji}\n` +
                              `Pasien: ${namaPasien}\n` +
                              `Dokter: ${namaDokter}\n\n` +
                              `Tindakan ini tidak dapat dibatalkan!`;
        
        if (!confirm(confirmMessage)) {
            e.preventDefault();
        }
    });

    // Auto-scroll to warning if appointment is active
    @if($janjiTemu->status === 'Hari Ini' || $janjiTemu->status === 'Akan Datang')
        document.addEventListener('DOMContentLoaded', function() {
            const warningAlert = document.querySelector('.alert-danger');
            if (warningAlert) {
                warningAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Add pulsing effect
                warningAlert.style.animation = 'pulse 2s infinite';
                setTimeout(() => {
                    warningAlert.style.animation = '';
                }, 6000);
            }
        });
    @endif
</script>

<style>
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>
@endpush
@endsection