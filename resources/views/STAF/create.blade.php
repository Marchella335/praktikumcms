@extends('layouts.app')

@section('title', 'Tambah Staf - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Staf Baru</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('staf.index') }}">Staf</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('staf.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Form Tambah Staf
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staf.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NAMA_STAF" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Staf <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('NAMA_STAF') is-invalid @enderror" 
                                       id="NAMA_STAF" 
                                       name="NAMA_STAF" 
                                       value="{{ old('NAMA_STAF') }}"
                                       placeholder="Masukkan nama lengkap staf"
                                       required>
                                @error('NAMA_STAF')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="DEPARTEMEN" class="form-label">
                                    <i class="fas fa-building me-1"></i>Departemen <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('DEPARTEMEN') is-invalid @enderror" 
                                        id="DEPARTEMEN" 
                                        name="DEPARTEMEN" 
                                        required>
                                    <option value="">Pilih Departemen</option>
                                    <option value="Administrasi" {{ old('DEPARTEMEN') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                    <option value="Keuangan" {{ old('DEPARTEMEN') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                    <option value="SDM" {{ old('DEPARTEMEN') == 'SDM' ? 'selected' : '' }}>SDM</option>
                                    <option value="IT" {{ old('DEPARTEMEN') == 'IT' ? 'selected' : '' }}>IT</option>
                                    <option value="Keamanan" {{ old('DEPARTEMEN') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                    <option value="Kebersihan" {{ old('DEPARTEMEN') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                    <option value="Farmasi" {{ old('DEPARTEMEN') == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                                    <option value="Laboratorium" {{ old('DEPARTEMEN') == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                                    <option value="Radiologi" {{ old('DEPARTEMEN') == 'Radiologi' ? 'selected' : '' }}>Radiologi</option>
                                    <option value="Gizi" {{ old('DEPARTEMEN') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                    <option value="Perawatan" {{ old('DEPARTEMEN') == 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                                    <option value="Lainnya" {{ old('DEPARTEMEN') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('DEPARTEMEN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NOMOR_TELEPON" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control @error('NOMOR_TELEPON') is-invalid @enderror" 
                                       id="NOMOR_TELEPON" 
                                       name="NOMOR_TELEPON" 
                                       value="{{ old('NOMOR_TELEPON') }}"
                                       placeholder="Contoh: 08123456789"
                                       required>
                                @error('NOMOR_TELEPON')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="GAJI" class="form-label">
                                    <i class="fas fa-money-bill-wave me-1"></i>Gaji <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('GAJI') is-invalid @enderror" 
                                           id="GAJI" 
                                           name="GAJI" 
                                           value="{{ old('GAJI') }}"
                                           placeholder="0"
                                           min="0"
                                           step="1000"
                                           required>
                                </div>
                                @error('GAJI')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Masukkan gaji dalam rupiah tanpa titik atau koma</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('staf.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data
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
    // Format gaji input
    document.getElementById('GAJI').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
    
    // Validation hints
    document.getElementById('NOMOR_TELEPON').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        e.target.value = value;
    });
</script>
@endpush
@endsection
