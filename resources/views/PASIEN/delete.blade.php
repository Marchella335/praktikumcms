@extends('layouts.app')

@section('title', 'Hapus Pasien - RS Cepat Sembuh')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Penghapusan Data Pasien
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
                                <p class="mb-0">Anda akan menghapus data pasien secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Patient Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Data Pasien yang akan dihapus:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>ID Pasien:</strong></td>
                                            <td>
                                                <span class="badge bg-secondary fs-6">{{ $pasien->ID_PASIEN }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>
                                                <span class="text-primary fw-bold">{{ $pasien->NAMA_PASIEN }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Kelamin:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $pasien->JENIS_KELAMIN }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Usia:</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $pasien->USIA }} tahun</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Status Pasien:</strong></td>
                                            <td>
                                                <span class="badge bg-warning text-dark">{{ $pasien->STATUS_PASIEN }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nomor Telepon:</strong></td>
                                            <td>{{ $pasien->NOMOR_TELEPON }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td class="text-muted">
                                                {{ Str::limit($pasien->ALAMAT, 50) }}
                                                @if(strlen($pasien->ALAMAT) > 50)
                                                    <span class="text-primary" data-bs-toggle="tooltip" title="{{ $pasien->ALAMAT }}">
                                                        (lihat selengkapnya)
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge bg-success">Aktif</span>
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
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Data pasien akan dihapus dari sistem</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Tidak dapat dikembalikan setelah dikonfirmasi</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Riwayat janji temu pasien (jika ada)</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Rekam medis pasien (jika ada)</li>
                                        <li><i class="fas fa-minus-circle text-danger me-2"></i>Relasi data pada entitas lain</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success"><i class="fas fa-check-circle"></i> Yang tetap aman:</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Data pasien lain tidak terpengaruh</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Sistem akan tetap berjalan normal</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Data dokter dan staf tetap aman</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Warning for Medical Records --}}
                    @if($pasien->STATUS_PASIEN !== 'Selesai')
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-heartbeat fa-2x text-danger me-3"></i>
                            <div>
                                <h6 class="mb-1">Perhatian Khusus!</h6>
                                <p class="mb-0">Pasien ini memiliki status <strong>{{ $pasien->STATUS_PASIEN }}</strong>. Pastikan tidak ada perawatan yang sedang berlangsung sebelum menghapus data.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Confirmation Checkbox --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label text-danger fw-bold" for="confirmDelete">
                            Saya memahami bahwa tindakan ini tidak dapat dibatalkan dan akan menghapus semua data pasien secara permanen
                        </label>
                    </div>

                    {{-- Confirmation Form --}}
                    <form action="{{ route('pasien.destroy', $pasien->ID_PASIEN) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pasien.index') }}" class="btn btn-secondary btn-lg">
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
        if (!confirm('Apakah Anda benar-benar yakin ingin menghapus data pasien "{{ $pasien->NAMA_PASIEN }}"? Tindakan ini tidak dapat dibatalkan!')) {
            e.preventDefault();
        }
    });
</script>
@endpush
@endsection