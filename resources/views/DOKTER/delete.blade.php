@extends('layouts.app')

@section('title', 'Hapus Dokter')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Penghapusan Data Dokter
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
                                <p class="mb-0">Anda akan menghapus data dokter secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Doctor Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user-md"></i> Data Dokter yang akan dihapus:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>ID Dokter:</strong></td>
                                            <td>
                                                <span class="badge bg-secondary fs-6">{{ $dokter->ID_DOKTER }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>
                                                <span class="text-primary fw-bold">{{ $dokter->NAMA_DOKTER }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Spesialisasi:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $dokter->SPESIALISASI }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nomor SIP:</strong></td>
                                            <td>
                                                <span class="badge bg-warning text-dark">{{ $dokter->NOMOR_SIP }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Jenis Kelamin:</strong></td>
                                            <td>{{ $dokter->JENIS_KELAMIN }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jadwal Praktek:</strong></td>
                                            <td>{{ $dokter->JADWAL_PRAKTEK }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gaji:</strong></td>
                                            <td>
                                                <span class="text-success fw-bold">Rp {{ number_format($dokter->GAJI, 0, ',', '.') }}</span>
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
                                        <li>Data dokter akan dihapus dari sistem</li>
                                        <li>Tidak dapat dikembalikan setelah dikonfirmasi</li>
                                        <li>Jadwal praktek dokter akan terhapus</li>
                                        <li>Relasi data pada entitas lain (jika ada) juga bisa terpengaruh</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success"><i class="fas fa-check-circle"></i> Yang tetap aman:</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li>Data dokter lain tidak terpengaruh</li>
                                        <li>Sistem akan tetap berjalan normal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Confirmation Form --}}
                    <form action="{{ route('dokter.destroy', $dokter->ID_DOKTER) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Hapus Permanen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection