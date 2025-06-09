@extends('layouts.app')

@section('title', 'Tambah Dokter - RS Cepat Sembuh')

@section('content')
<div class="container-fluid">
    <!-- Animated Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="animate__animated animate__fadeInLeft">
                            <h1 class="h2 mb-2 fw-bold">
                                <i class="fas fa-user-md me-3"></i>Tambah Dokter Baru
                            </h1>
                            <p class="mb-0 opacity-75">Lengkapi informasi dokter untuk menambahkan ke sistem</p>
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}" class="text-white-50">
                                            <i class="fas fa-home me-1"></i>Dashboard
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dokter.index') }}" class="text-white-50">Dokter</a>
                                    </li>
                                    <li class="breadcrumb-item active text-white">Tambah</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="animate__animated animate__fadeInRight">
                            <a href="{{ route('dokter.index') }}" class="btn btn-light btn-lg shadow">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2 fa-lg"></i>
                <div>
                    <strong>Oops!</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="card border-0 shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary text-white me-3">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Form Data Dokter</h5>
                            <small class="text-muted">Isi semua field yang diperlukan dengan lengkap</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('dokter.store') }}" method="POST" id="dokterForm">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="section-divider mb-4">
                            <h6 class="section-title">
                                <i class="fas fa-user-circle me-2 text-primary"></i>Informasi Personal
                            </h6>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" 
                                           class="form-control form-control-lg @error('NAMA_DOKTER') is-invalid @enderror" 
                                           id="NAMA_DOKTER" 
                                           name="NAMA_DOKTER" 
                                           value="{{ old('NAMA_DOKTER') }}"
                                           placeholder="Dr. Nama Lengkap"
                                           required>
                                    <label for="NAMA_DOKTER">
                                        <i class="fas fa-user me-2"></i>Nama Lengkap Dokter
                                    </label>
                                    @error('NAMA_DOKTER')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select form-select-lg @error('JENIS_KELAMIN') is-invalid @enderror" 
                                            id="JENIS_KELAMIN" 
                                            name="JENIS_KELAMIN" 
                                            required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('JENIS_KELAMIN') == 'Laki-laki' ? 'selected' : '' }}>
                                            👨‍⚕️ Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ old('JENIS_KELAMIN') == 'Perempuan' ? 'selected' : '' }}>
                                            👩‍⚕️ Perempuan
                                        </option>
                                    </select>
                                    <label for="JENIS_KELAMIN">
                                        <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                    </label>
                                    @error('JENIS_KELAMIN')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information Section -->
                        <div class="section-divider mb-4">
                            <h6 class="section-title">
                                <i class="fas fa-briefcase-medical me-2 text-success"></i>Informasi Profesional
                            </h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select form-select-lg @error('SPESIALISASI') is-invalid @enderror" 
                                            id="SPESIALISASI" 
                                            name="SPESIALISASI" 
                                            required>
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="Umum" {{ old('SPESIALISASI') == 'Umum' ? 'selected' : '' }}>🏥 Dokter Umum</option>
                                        <option value="Anak" {{ old('SPESIALISASI') == 'Anak' ? 'selected' : '' }}>👶 Dokter Anak</option>
                                        <option value="Gigi" {{ old('SPESIALISASI') == 'Gigi' ? 'selected' : '' }}>🦷 Dokter Gigi</option>
                                        <option value="Mata" {{ old('SPESIALISASI') == 'Mata' ? 'selected' : '' }}>👁️ Dokter Mata</option>
                                        <option value="Jantung" {{ old('SPESIALISASI') == 'Jantung' ? 'selected' : '' }}>❤️ Dokter Jantung</option>
                                        <option value="Penyakit Dalam" {{ old('SPESIALISASI') == 'Penyakit Dalam' ? 'selected' : '' }}>🩺 Penyakit Dalam</option>
                                        <option value="Bedah" {{ old('SPESIALISASI') == 'Bedah' ? 'selected' : '' }}>🏥 Bedah Umum</option>
                                        <option value="Kandungan" {{ old('SPESIALISASI') == 'Kandungan' ? 'selected' : '' }}>🤱 Kandungan</option>
                                        <option value="Kulit" {{ old('SPESIALISASI') == 'Kulit' ? 'selected' : '' }}>🔬 Kulit & Kelamin</option>
                                        <option value="Saraf" {{ old('SPESIALISASI') == 'Saraf' ? 'selected' : '' }}>🧠 Saraf</option>
                                        <option value="THT" {{ old('SPESIALISASI') == 'THT' ? 'selected' : '' }}>👂 THT</option>
                                        <option value="Ortopedi" {{ old('SPESIALISASI') == 'Ortopedi' ? 'selected' : '' }}>🦴 Ortopedi</option>
                                    </select>
                                    <label for="SPESIALISASI">
                                        <i class="fas fa-stethoscope me-2"></i>Spesialisasi
                                    </label>
                                    @error('SPESIALISASI')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" 
                                           class="form-control form-control-lg @error('NOMOR_SIP') is-invalid @enderror" 
                                           id="NOMOR_SIP" 
                                           name="NOMOR_SIP" 
                                           value="{{ old('NOMOR_SIP') }}"
                                           placeholder="SIP-123456789"
                                           required>
                                    <label for="NOMOR_SIP">
                                        <i class="fas fa-id-card me-2"></i>Nomor SIP
                                    </label>
                                    @error('NOMOR_SIP')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Surat Izin Praktik Dokter
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('JADWAL_PRAKTEK') is-invalid @enderror" 
                                              id="JADWAL_PRAKTEK" 
                                              name="JADWAL_PRAKTEK" 
                                              style="height: 100px"
                                              placeholder="Contoh: Senin-Jumat: 08:00-12:00, Sabtu: 08:00-10:00"
                                              required>{{ old('JADWAL_PRAKTEK') }}</textarea>
                                    <label for="JADWAL_PRAKTEK">
                                        <i class="fas fa-clock me-2"></i>Jadwal Praktek
                                    </label>
                                    @error('JADWAL_PRAKTEK')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Masukkan jadwal praktek lengkap dengan hari dan jam
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information Section -->
                        <div class="section-divider mb-4">
                            <h6 class="section-title">
                                <i class="fas fa-money-bill-wave me-2 text-warning"></i>Informasi Keuangan
                            </h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" 
                                           class="form-control form-control-lg @error('GAJI') is-invalid @enderror" 
                                           id="GAJI" 
                                           name="GAJI" 
                                           value="{{ old('GAJI') }}"
                                           placeholder="0"
                                           min="0"
                                           step="100000"
                                           required>
                                    <label for="GAJI">
                                        <i class="fas fa-money-bill-wave me-2"></i>Gaji (Rp)
                                    </label>
                                    @error('GAJI')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Masukkan gaji dalam rupiah tanpa titik atau koma
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="salary-preview p-3 bg-light rounded">
                                    <h6 class="mb-2">💰 Preview Gaji:</h6>
                                    <div id="gajiPreview" class="fw-bold text-success fs-5">Rp 0</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('dokter.index') }}" class="btn btn-secondary btn-lg px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4 shadow">
                                <i class="fas fa-save me-2"></i>Simpan Data Dokter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .section-divider {
        position: relative;
        text-align: center;
        margin: 2rem 0;
    }
    
    .section-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #ddd, transparent);
    }
    
    .section-title {
        background: white;
        padding: 0 1rem;
        font-weight: 600;
        color: #495057;
        display: inline-block;
    }
    
    .form-floating > .form-control {
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .form-floating > .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }
    
    .form-floating > label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .salary-preview {
        border: 2px dashed #28a745;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .btn-lg {
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .card {
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .breadcrumb-dark .breadcrumb-item a {
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .breadcrumb-dark .breadcrumb-item a:hover {
        color: white !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Format gaji input dengan preview
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    document.getElementById('GAJI').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
        
        // Update preview
        if (value) {
            document.getElementById('gajiPreview').textContent = formatRupiah(value);
        } else {
            document.getElementById('gajiPreview').textContent = 'Rp 0';
        }
    });
    
    // Auto format SIP number
    document.getElementById('NOMOR_SIP').addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase();
        if (!value.startsWith('SIP-') && value.length > 0) {
            value = 'SIP-' + value.replace('SIP-', '');
        }
        e.target.value = value;
    });
    
    // Form submission with loading state
    document.getElementById('dokterForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Re-enable if form validation fails
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }, 3000);
    });
    
    // Add floating animations on scroll
    window.addEventListener('scroll', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                card.style.transform = 'translateY(0)';
                card.style.opacity = '1';
            }
        });
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });
    });
</script>
@endpush
@endsection