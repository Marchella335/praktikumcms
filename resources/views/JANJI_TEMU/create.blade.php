@extends('layouts.app')

@section('title', 'Tambah Janji Temu - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Janji Temu Baru</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('janji_temu.index') }}">Janji Temu</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('janji_temu.index') }}" class="btn btn-secondary">
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
                        <i class="fas fa-calendar-plus me-2"></i>Form Tambah Janji Temu
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('janji_temu.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ID_PASIEN" class="form-label">
                                    <i class="fas fa-user me-1"></i>Pasien <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('ID_PASIEN') is-invalid @enderror" 
                                        id="ID_PASIEN" 
                                        name="ID_PASIEN" 
                                        required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach($pasien as $p)
                                        <option value="{{ $p->id_pasien }}" {{ old('ID_PASIEN') == $p->id_pasien ? 'selected' : '' }}>
                                            {{ $p->nama_pasien }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ID_PASIEN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="ID_DOKTER" class="form-label">
                                    <i class="fas fa-user-md me-1"></i>Dokter <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('ID_DOKTER') is-invalid @enderror" 
                                        id="ID_DOKTER" 
                                        name="ID_DOKTER" 
                                        required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach($dokter as $d)
                                        <option value="{{ $d->id_dokter }}" {{ old('ID_DOKTER') == $d->id_dokter ? 'selected' : '' }}>
                                            {{ $d->nama_dokter }} - {{ $d->spesialisasi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ID_DOKTER')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="TANGGAL_JANJI" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Tanggal Janji <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('TANGGAL_JANJI') is-invalid @enderror" 
                                       id="TANGGAL_JANJI" 
                                       name="TANGGAL_JANJI" 
                                       value="{{ old('TANGGAL_JANJI') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('TANGGAL_JANJI')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tanggal tidak boleh sebelum hari ini</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="JAM_JANJI" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Jam Janji <span class="text-danger">*</span>
                                </label>
                                <input type="time" 
                                       class="form-control @error('JAM_JANJI') is-invalid @enderror" 
                                       id="JAM_JANJI" 
                                       name="JAM_JANJI" 
                                       value="{{ old('JAM_JANJI') }}"
                                       min="08:00"
                                       max="17:00"
                                       required>
                                @error('JAM_JANJI')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Jam praktik: 08:00 - 17:00</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="KELUHAN" class="form-label">
                                <i class="fas fa-notes-medical me-1"></i>Keluhan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('KELUHAN') is-invalid @enderror" 
                                      id="KELUHAN" 
                                      name="KELUHAN" 
                                      rows="4"
                                      placeholder="Tuliskan keluhan atau gejala yang dirasakan pasien"
                                      maxlength="1000"
                                      required>{{ old('KELUHAN') }}</textarea>
                            @error('KELUHAN')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <span id="keluhanCount">0</span>/1000 karakter
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('janji_temu.index') }}" class="btn btn-secondary">
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
    // Character counter for keluhan
    document.getElementById('KELUHAN').addEventListener('input', function(e) {
        const count = e.target.value.length;
        document.getElementById('keluhanCount').textContent = count;
        
        if (count > 950) {
            document.getElementById('keluhanCount').style.color = 'red';
        } else if (count > 800) {
            document.getElementById('keluhanCount').style.color = 'orange';
        } else {
            document.getElementById('keluhanCount').style.color = 'inherit';
        }
    });

    // Initialize character counter on page load
    document.addEventListener('DOMContentLoaded', function() {
        const keluhanTextarea = document.getElementById('KELUHAN');
        if (keluhanTextarea.value) {
            const count = keluhanTextarea.value.length;
            document.getElementById('keluhanCount').textContent = count;
        }
    });

    // Format phone number input (for consistency)
    document.getElementById('NOMOR_TELEPON')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        e.target.value = value;
    });
</script>
@endpush
@endsection