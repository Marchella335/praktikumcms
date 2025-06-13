@extends('layouts.app')

@section('title', 'Tambah Rekam Medis - RS Cepat Sembuh')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Tambah Rekam Medis Baru</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('rekam_medis.index') }}">Rekam Medis</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
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
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-medical me-2"></i>Form Tambah Rekam Medis
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rekam_medis.store') }}" method="POST">
                        @csrf
                        
                        <!-- Informasi Dasar -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h6>
                            </div>
                        </div>

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
                                <label for="ID_STAF" class="form-label">
                                    <i class="fas fa-users me-1"></i>Staf (Opsional)
                                </label>
                                <select class="form-select @error('ID_STAF') is-invalid @enderror" 
                                        id="ID_STAF" 
                                        name="ID_STAF">
                                    <option value="">Pilih Staf</option>
                                    @foreach($staf as $s)
                                        <option value="{{ $s->id_staf }}" {{ old('ID_STAF') == $s->id_staf ? 'selected' : '' }}>
                                            {{ $s->nama_staf }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ID_STAF')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="TANGGAL" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Tanggal Pemeriksaan <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('TANGGAL') is-invalid @enderror" 
                                       id="TANGGAL" 
                                       name="TANGGAL" 
                                       value="{{ old('TANGGAL', date('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('TANGGAL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Medis -->
                        <div class="row mb-4 mt-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-stethoscope me-2"></i>Informasi Medis
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="HASIL_PEMERIKSAAN" class="form-label">
                                    <i class="fas fa-clipboard-check me-1"></i>Hasil Pemeriksaan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('HASIL_PEMERIKSAAN') is-invalid @enderror" 
                                          id="HASIL_PEMERIKSAAN" 
                                          name="HASIL_PEMERIKSAAN" 
                                          rows="4"
                                          placeholder="Masukkan hasil pemeriksaan yang dilakukan..."
                                          maxlength="2000"
                                          required>{{ old('HASIL_PEMERIKSAAN') }}</textarea>
                                @error('HASIL_PEMERIKSAAN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 2000 karakter</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="RIWAYAT_REKAM_MEDIS" class="form-label">
                                    <i class="fas fa-history me-1"></i>Riwayat Rekam Medis (Opsional)
                                </label>
                                <textarea class="form-control @error('RIWAYAT_REKAM_MEDIS') is-invalid @enderror" 
                                          id="RIWAYAT_REKAM_MEDIS" 
                                          name="RIWAYAT_REKAM_MEDIS" 
                                          rows="3"
                                          placeholder="Masukkan riwayat rekam medis pasien..."
                                          maxlength="2000">{{ old('RIWAYAT_REKAM_MEDIS') }}</textarea>
                                @error('RIWAYAT_REKAM_MEDIS')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 2000 karakter</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="DIAGNOSA" class="form-label">
                                    <i class="fas fa-diagnoses me-1"></i>Diagnosa <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('DIAGNOSA') is-invalid @enderror" 
                                          id="DIAGNOSA" 
                                          name="DIAGNOSA" 
                                          rows="3"
                                          placeholder="Masukkan diagnosa penyakit..."
                                          maxlength="1000"
                                          required>{{ old('DIAGNOSA') }}</textarea>
                                @error('DIAGNOSA')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 1000 karakter</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="TINDAKAN" class="form-label">
                                    <i class="fas fa-procedures me-1"></i>Tindakan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('TINDAKAN') is-invalid @enderror" 
                                          id="TINDAKAN" 
                                          name="TINDAKAN" 
                                          rows="3"
                                          placeholder="Masukkan tindakan yang dilakukan..."
                                          maxlength="1000"
                                          required>{{ old('TINDAKAN') }}</textarea>
                                @error('TINDAKAN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 1000 karakter</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="OBAT" class="form-label">
                                    <i class="fas fa-pills me-1"></i>Obat (Opsional)
                                </label>
                                <textarea class="form-control @error('OBAT') is-invalid @enderror" 
                                          id="OBAT" 
                                          name="OBAT" 
                                          rows="3"
                                          placeholder="Masukkan obat yang diberikan..."
                                          maxlength="1000">{{ old('OBAT') }}</textarea>
                                @error('OBAT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 1000 karakter</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Rekam Medis
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
    // Character counter for textareas
    function setupCharacterCounter(textareaId, maxLength) {
        const textarea = document.getElementById(textareaId);
        const counter = document.createElement('div');
        counter.className = 'form-text text-end';
        counter.style.fontSize = '0.8em';
        textarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${textarea.value.length}/${maxLength} karakter`;
            counter.className = remaining < 50 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    }

    // Setup character counters for all textareas
    document.addEventListener('DOMContentLoaded', function() {
        setupCharacterCounter('HASIL_PEMERIKSAAN', 2000);
        setupCharacterCounter('RIWAYAT_REKAM_MEDIS', 2000);
        setupCharacterCounter('DIAGNOSA', 1000);
        setupCharacterCounter('TINDAKAN', 1000);
        setupCharacterCounter('OBAT', 1000);
    });

    // Auto-resize textareas
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Apply auto-resize to all textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', () => autoResize(textarea));
        autoResize(textarea); // Initial resize
    });

    // Validate form before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['ID_PASIEN', 'ID_DOKTER', 'TANGGAL', 'HASIL_PEMERIKSAAN', 'DIAGNOSA', 'TINDAKAN'];
        let isValid = true;
        
        requiredFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });

    // Real-time validation
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Date validation
    document.getElementById('TANGGAL').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        
        if (selectedDate > today) {
            this.setCustomValidity('Tanggal pemeriksaan tidak boleh lebih dari hari ini.');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });

    // Enhanced select styling with search
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#ID_PASIEN, #ID_DOKTER, #ID_STAF').select2({
            theme: 'bootstrap-5',
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: true
        });
    }
</script>
@endpush

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .border-bottom {
        border-bottom: 2px solid #e9ecef !important;
    }
    
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    .form-text {
        margin-top: 0.25rem;
    }
    
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        display: block;
    }
    
    .alert {
        border: none;
        border-radius: 0.5rem;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
</style>
@endpush
@endsection