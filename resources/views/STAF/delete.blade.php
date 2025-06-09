@extends('layouts.app')

@section('title', 'Hapus Staf')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Penghapusan Data Staf
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
                                <p class="mb-0">Anda akan menghapus data staf secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Staff Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Data Staf yang akan dihapus:</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>ID Staf:</strong></td>
                                            <td>
                                                <span class="badge bg-secondary fs-6">{{ $staf->ID_STAF }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>
                                                <span class="text-primary fw-bold">{{ $staf->NAMA_STAF }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Departemen:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $staf->DEPARTEMEN }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Telepon:</strong></td>
                                            <td>{{ $staf->NOMOR_TELEPON }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gaji:</strong></td>
                                            <td>
                                                <span class="text-success fw-bold">Rp {{ number_format($staf->GAJI, 0, ',', '.') }}</span>
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
                                    <ul class="list-uns
                                    <ul class="list-unstyled ms-3">
                            <li>Data staf akan dihapus dari sistem</li>
                            <li>Tidak dapat dikembalikan setelah dikonfirmasi</li>
                            <li>Relasi data pada entitas lain (jika ada) juga bisa terpengaruh</li>
                        </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-check-circle"></i> Yang tetap aman:</h6>
                            <ul class="list-unstyled ms-3">
                                <li>Data staf lain tidak terpengaruh</li>
                                <li>Sistem akan tetap berjalan normal</li>
                            </ul>
                        </div>
                        </div>
                        </div>
                        </div>

                        {{-- Confirmation Form --}}
                        <form action="{{ route('staf.destroy', $staf->ID_STAF) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('staf.index') }}" class="btn btn-secondary">
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
