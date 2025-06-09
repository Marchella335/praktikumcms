@extends('layouts.app')

@section('title', 'Edit Staf')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Data Staf</h3>
                    <div>
                        <a href="{{ route('staf.show', $staf->id_staf) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('staf.index') }}" class="btn btn-secondary">
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
                        <strong>{{ $staf->nama_staf }}</strong> - {{ $staf->departemen }} |
                        Telepon: {{ $staf->nomor_telepon }} |
                        Gaji: Rp {{ number_format($staf->gaji, 0, ',', '.') }}
                    </div>

                    <form action="{{ route('staf.update', $staf->id_staf) }}" method="POST" id="stafForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_staf" class="form-label">
                                        Nama Staf <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nama_staf') is-invalid @enderror"
                                           id="nama_staf"
                                           name="nama_staf"
                                           value="{{ old('nama_staf', $staf->nama_staf) }}"
                                           placeholder="Masukkan nama lengkap staf"
                                           required>
                                    @error('nama_staf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departemen" class="form-label">
                                        Departemen <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('departemen') is-invalid @enderror"
                                            id="departemen"
                                            name="departemen"
                                            required>
                                        <option value="">Pilih Departemen</option>
                                        @php
                                            $departments = ['Administrasi', 'Medis', 'Keperawatan', 'Farmasi', 'Laboratorium', 'Radiologi', 'Gizi', 'Kebersihan', 'Keamanan', 'IT', 'Keuangan', 'SDM'];
                                        @endphp
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}" {{ old('departemen', $staf->departemen) == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departemen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">
                                        Nomor Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('nomor_telepon') is-invalid @enderror"
                                           id="nomor_telepon"
                                           name="nomor_telepon"
                                           value="{{ old('nomor_telepon', $staf->nomor_telepon) }}"
                                           placeholder="Contoh: 08123456789"
                                           pattern="[0-9+\-\s]+"
                                           required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: 08123456789 atau +628123456789</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gaji" class="form-label">
                                        Gaji <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                               class="form-control @error('gaji') is-invalid @enderror"
                                               id="gaji"
                                               name="gaji"
                                               value="{{ old('gaji', $staf->gaji) }}"
                                               placeholder="Masukkan gaji"
                                               min="0"
                                               step="1000"
                                               required>
                                        @error('gaji')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Masukkan nominal tanpa titik atau koma</div>
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
                                        <p><strong>Nama:</strong> {{ $staf->nama_staf }}</p>
                                        <p><strong>Departemen:</strong> {{ $staf->departemen }}</p>
                                        <p><strong>Telepon:</strong> {{ $staf->nomor_telepon }}</p>
                                        <p><strong>Gaji:</strong> Rp {{ number_format($staf->gaji, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Baru:</h6>
                                        <p><strong>Nama:</strong> <span id="newNama">{{ $staf->nama_staf }}</span></p>
                                        <p><strong>Departemen:</strong> <span id="newDept">{{ $staf->departemen }}</span></p>
                                        <p><strong>Telepon:</strong> <span id="newTelp">{{ $staf->nomor_telepon }}</span></p>
                                        <p><strong>Gaji:</strong> <span id="newGaji">Rp {{ number_format($staf->gaji, 0, ',', '.') }}</span></p>
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
                                        <a href="{{ route('staf.index') }}" class="btn btn-secondary">
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
    const form = document.getElementById('stafForm');
    const comparisonCard = document.getElementById('comparisonCard');
    const originalData = {
        nama: '{{ $staf->nama_staf }}',
        departemen: '{{ $staf->departemen }}',
        telepon: '{{ $staf->nomor_telepon }}',
        gaji: {{ $staf->gaji }}
    };

    // Monitor changes in form
    form.addEventListener('input', function() {
        const currentData = {
            nama: document.getElementById('nama_staf').value,
            departemen: document.getElementById('departemen').value,
            telepon: document.getElementById('nomor_telepon').value,
            gaji: parseFloat(document.getElementById('gaji').value) || 0
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
        document.getElementById('newDept').textContent = newData.departemen;
        document.getElementById('newTelp').textContent = newData.telepon;
        document.getElementById('newGaji').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newData.gaji);
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const nama = document.getElementById('nama_staf').value.trim();
        const departemen = document.getElementById('departemen').value;
        const telepon = document.getElementById('nomor_telepon').value.trim();
        const gaji = document.getElementById('gaji').value;

        if (!nama || !departemen || !telepon || !gaji) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }

        if (gaji < 0) {
            e.preventDefault();
            alert('Gaji tidak boleh negatif!');
            return false;
        }

        if (confirm('Apakah Anda yakin ingin menyimpan perubahan data ini?')) {
            // Form will be submitted
        } else {
            e.preventDefault();
        }
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
        document.getElementById('nama_staf').value = '{{ $staf->nama_staf }}';
        document.getElementById('departemen').value = '{{ $staf->departemen }}';
        document.getElementById('nomor_telepon').value = '{{ $staf->nomor_telepon }}';
        document.getElementById('gaji').value = '{{ $staf->gaji }}';
        document.getElementById('comparisonCard').style.display = 'none';
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
</style>
@endsection
