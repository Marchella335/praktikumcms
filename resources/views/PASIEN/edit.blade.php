@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Data Pasien</h3>
                    <div>
                        <a href="{{ route('pasien.show', $pasien->id_pasien) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Alert Messages --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Current Data Info --}}
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Data Saat Ini:</h6>
                        <strong>{{ $pasien->nama_pasien }}</strong> - {{ $pasien->usia }} Tahun |
                        {{ $pasien->jenis_kelamin }} |
                        Telepon: {{ $pasien->nomor_telepon }} |
                        Status: {{ $pasien->status_pasien }}
                    </div>

                    <form action="{{ route('pasien.update', $pasien->id_pasien) }}" method="POST" id="pasienForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pasien" class="form-label">
                                        Nama Pasien <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nama_pasien') is-invalid @enderror"
                                           id="nama_pasien"
                                           name="nama_pasien"
                                           value="{{ old('nama_pasien', $pasien->nama_pasien) }}"
                                           placeholder="Masukkan nama lengkap pasien"
                                           required>
                                    @error('nama_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">
                                        Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                            id="jenis_kelamin"
                                            name="jenis_kelamin"
                                            required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usia" class="form-label">
                                        Usia <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control @error('usia') is-invalid @enderror"
                                               id="usia"
                                               name="usia"
                                               value="{{ old('usia', $pasien->usia) }}"
                                               placeholder="Masukkan usia"
                                               min="0"
                                               max="150"
                                               required>
                                        <span class="input-group-text">Tahun</span>
                                        @error('usia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Usia pasien dalam tahun</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">
                                        Nomor Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('nomor_telepon') is-invalid @enderror"
                                           id="nomor_telepon"
                                           name="nomor_telepon"
                                           value="{{ old('nomor_telepon', $pasien->nomor_telepon) }}"
                                           placeholder="Contoh: 081234567890"
                                           required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nomor telepon yang dapat dihubungi</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status_pasien" class="form-label">
                                        Status Pasien <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status_pasien') is-invalid @enderror"
                                            id="status_pasien"
                                            name="status_pasien"
                                            required>
                                        <option value="">Pilih Status Pasien</option>
                                        @php
                                            $statusList = [
                                                'Rawat Jalan',
                                                'Rawat Inap',
                                                'Gawat Darurat',
                                                'Sembuh',
                                                'Rujuk',
                                                'Kontrol',
                                                'Observasi',
                                                'Pulang Paksa'
                                            ];
                                        @endphp
                                        @foreach($statusList as $status)
                                            <option value="{{ $status }}" {{ old('status_pasien', $pasien->status_pasien) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                              id="alamat"
                                              name="alamat"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap pasien"
                                              required>{{ old('alamat', $pasien->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Alamat tempat tinggal pasien</div>
                                </div>
                            </div>
                        </div>

                        {{-- Change Comparison --}}
                        <div class="card bg-light mt-4" id="comparisonCard" style="display: none;">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-exchange-alt"></i> Perbandingan Perubahan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Lama:</h6>
                                        <p><strong>Nama:</strong> {{ $pasien->nama_pasien }}</p>
                                        <p><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin }}</p>
                                        <p><strong>Usia:</strong> {{ $pasien->usia }} Tahun</p>
                                        <p><strong>Telepon:</strong> {{ $pasien->nomor_telepon }}</p>
                                        <p><strong>Status:</strong> {{ $pasien->status_pasien }}</p>
                                        <p><strong>Alamat:</strong> {{ Str::limit($pasien->alamat, 30) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Baru:</h6>
                                        <p><strong>Nama:</strong> <span id="newNama">{{ $pasien->nama_pasien }}</span></p>
                                        <p><strong>Jenis Kelamin:</strong> <span id="newGender">{{ $pasien->jenis_kelamin }}</span></p>
                                        <p><strong>Usia:</strong> <span id="newUsia">{{ $pasien->usia }} Tahun</span></p>
                                        <p><strong>Telepon:</strong> <span id="newTelepon">{{ $pasien->nomor_telepon }}</span></p>
                                        <p><strong>Status:</strong> <span id="newStatus">{{ $pasien->status_pasien }}</span></p>
                                        <p><strong>Alamat:</strong> <span id="newAlamat">{{ Str::limit($pasien->alamat, 30) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-warning me-2" onclick="resetForm()">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pasienForm');
    const comparisonCard = document.getElementById('comparisonCard');
    const originalData = {
        nama: '{{ $pasien->nama_pasien }}',
        gender: '{{ $pasien->jenis_kelamin }}',
        usia: {{ $pasien->usia }},
        telepon: '{{ $pasien->nomor_telepon }}',
        status: '{{ $pasien->status_pasien }}',
        alamat: `{{ $pasien->alamat }}`
    };

    // Monitor changes in form
    form.addEventListener('input', function() {
        const currentData = {
            nama: document.getElementById('nama_pasien').value,
            gender: document.getElementById('jenis_kelamin').value,
            usia: parseInt(document.getElementById('usia').value) || 0,
            telepon: document.getElementById('nomor_telepon').value,
            status: document.getElementById('status_pasien').value,
            alamat: document.getElementById('alamat').value
        };

        // Check if any data has changed
        const hasChanges = Object.keys(originalData).some(key => 
            originalData[key] != currentData[key]
        );

        if (hasChanges) {
            comparisonCard.style.display = 'block';
            updateComparison(currentData);
        } else {
            comparisonCard.style.display = 'none';
        }
    });

    function updateComparison(newData) {
        document.getElementById('newNama').textContent = newData.nama;
        document.getElementById('newGender').textContent = newData.gender;
        document.getElementById('newUsia').textContent = newData.usia + ' Tahun';
        document.getElementById('newTelepon').textContent = newData.telepon;
        document.getElementById('newStatus').textContent = newData.status;
        document.getElementById('newAlamat').textContent = newData.alamat.substring(0, 30) + (newData.alamat.length > 30 ? '...' : '');
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const nama = document.getElementById('nama_pasien').value.trim();
        const gender = document.getElementById('jenis_kelamin').value;
        const usia = document.getElementById('usia').value;
        const telepon = document.getElementById('nomor_telepon').value.trim();
        const status = document.getElementById('status_pasien').value;
        const alamat = document.getElementById('alamat').value.trim();

        if (!nama || !gender || !usia || !telepon || !status || !alamat) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }

        if (usia < 0 || usia > 150) {
            e.preventDefault();
            alert('Usia harus antara 0-150 tahun!');
            return false;
        }

        // Basic phone number validation
        const phoneRegex = /^[0-9+\-\s()]+$/;
        if (!phoneRegex.test(telepon)) {
            e.preventDefault();
            alert('Format nomor telepon tidak valid!');
            return false;
        }

        if (confirm('Apakah Anda yakin ingin menyimpan perubahan data pasien ini?')) {
            // Form will be submitted
        } else {
            e.preventDefault();
        }
    });

    // Auto-format phone number
    document.getElementById('nomor_telepon').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('0')) {
            value = '+62' + value.substring(1);
        }
        // Don't auto-format if user is typing normally
        // This is just a basic example - you can implement more sophisticated formatting
    });

    // Age category indicator
    document.getElementById('usia').addEventListener('input', function(e) {
        const usia = parseInt(e.target.value);
        const helpText = e.target.nextElementSibling.nextElementSibling;
        
        if (usia < 12) {
            helpText.textContent = 'Kategori: Anak-anak';
            helpText.className = 'form-text text-info';
        } else if (usia < 18) {
            helpText.textContent = 'Kategori: Remaja';
            helpText.className = 'form-text text-primary';
        } else if (usia < 60) {
            helpText.textContent = 'Kategori: Dewasa';
            helpText.className = 'form-text text-success';
        } else if (usia >= 60) {
            helpText.textContent = 'Kategori: Lansia';
            helpText.className = 'form-text text-warning';
        } else {
            helpText.textContent = 'Usia pasien dalam tahun';
            helpText.className = 'form-text';
        }
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
        document.getElementById('nama_pasien').value = '{{ $pasien->nama_pasien }}';
        document.getElementById('jenis_kelamin').value = '{{ $pasien->jenis_kelamin }}';
        document.getElementById('usia').value = '{{ $pasien->usia }}';
        document.getElementById('nomor_telepon').value = '{{ $pasien->nomor_telepon }}';
        document.getElementById('status_pasien').value = '{{ $pasien->status_pasien }}';
        document.getElementById('alamat').value = `{{ $pasien->alamat }}`;
        document.getElementById('comparisonCard').style.display = 'none';
        
        // Reset age category
        const helpText = document.getElementById('usia').nextElementSibling.nextElementSibling;
        helpText.textContent = 'Usia pasien dalam tahun';
        helpText.className = 'form-text';
    }
}
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 0.375rem;
}

.alert {
    border-radius: 0.375rem;
}

#comparisonCard {
    border-left: 4px solid #ffc107;
}

.text-danger {
    color: #dc3545 !important;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.form-text.text-info {
    color: #0dcaf0 !important;
}

.form-text.text-primary {
    color: #0d6efd !important;
}

.form-text.text-success {
    color: #198754 !important;
}

.form-text.text-warning {
    color: #ffc107 !important;
}
</style>
@endsection