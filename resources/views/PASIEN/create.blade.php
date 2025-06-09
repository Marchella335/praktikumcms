@extends('layouts.app')

@section('title', 'Tambah Pasien - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Pasien Baru</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pasien.index') }}">Pasien</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
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
                        <i class="fas fa-user-plus me-2"></i>Form Tambah Pasien
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pasien.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NAMA_PASIEN" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Pasien <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('NAMA_PASIEN') is-invalid @enderror" 
                                       id="NAMA_PASIEN" 
                                       name="NAMA_PASIEN" 
                                       value="{{ old('NAMA_PASIEN') }}"
                                       placeholder="Masukkan nama lengkap pasien"
                                       required>
                                @error('NAMA_PASIEN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="USIA" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Usia <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('USIA') is-invalid @enderror" 
                                           id="USIA" 
                                           name="USIA" 
                                           value="{{ old('USIA') }}"
                                           placeholder="0"
                                           min="0"
                                           max="150"
                                           required>
                                    <span class="input-group-text">tahun</span>
                                </div>
                                @error('USIA')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="JENIS_KELAMIN" class="form-label">
                                    <i class="fas fa-venus-mars me-1"></i>Jenis Kelamin <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('JENIS_KELAMIN') is-invalid @enderror" 
                                        id="JENIS_KELAMIN" 
                                        name="JENIS_KELAMIN" 
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('JENIS_KELAMIN') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('JENIS_KELAMIN') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('JENIS_KELAMIN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
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
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="STATUS_PASIEN" class="form-label">
                                    <i class="fas fa-heartbeat me-1"></i>Status Pasien <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('STATUS_PASIEN') is-invalid @enderror" 
                                        id="STATUS_PASIEN" 
                                        name="STATUS_PASIEN" 
                                        required>
                                    <option value="">Pilih Status Pasien</option>
                                    <option value="Rawat Jalan" {{ old('STATUS_PASIEN') == 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                                    <option value="Rawat Inap" {{ old('STATUS_PASIEN') == 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                                    <option value="IGD" {{ old('STATUS_PASIEN') == 'IGD' ? 'selected' : '' }}>IGD</option>
                                    <option value="ICU" {{ old('STATUS_PASIEN') == 'ICU' ? 'selected' : '' }}>ICU</option>
                                    <option value="Konsultasi" {{ old('STATUS_PASIEN') == 'Konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                                    <option value="Pemeriksaan" {{ old('STATUS_PASIEN') == 'Pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
                                    <option value="Selesai" {{ old('STATUS_PASIEN') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('STATUS_PASIEN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ALAMAT" class="form-label">
                                <i class="fas fa-map-marker-alt me-1"></i>Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('ALAMAT') is-invalid @enderror" 
                                      id="ALAMAT" 
                                      name="ALAMAT" 
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap pasien"
                                      required>{{ old('ALAMAT') }}</textarea>
                            @error('ALAMAT')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Masukkan alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan, Kota</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
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
    // Validation for phone number
    document.getElementById('NOMOR_TELEPON').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 20) {
            value = value.substring(0, 20);
        }
        e.target.value = value;
    });
    
    // Validation for age
    document.getElementById('USIA').addEventListener('input', function(e) {
        let value = parseInt(e.target.value);
        if (value < 0) {
            e.target.value = 0;
        } else if (value > 150) {
            e.target.value = 150;
        }
    });

    // Auto-format name (capitalize first letter of each word)
    document.getElementById('NAMA_PASIEN').addEventListener('blur', function(e) {
        let value = e.target.value;
        e.target.value = value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
    });
</script>
@endpush
@endsection