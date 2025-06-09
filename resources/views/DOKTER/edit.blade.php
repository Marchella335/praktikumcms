@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Data Dokter</h3>
                    <div>
                        <a href="{{ route('dokter.show', $dokter->id_dokter) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
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
                        <strong>{{ $dokter->nama_dokter}}</strong> - {{ $dokter->spesialisasi }} |
                        SIP: {{ $dokter->nomor_sip }} |
                        Gaji: Rp {{ number_format($dokter->gaji, 0, ',', '.') }}
                    </div>

                    <form action="{{ route('dokter.update', $dokter->id_dokter) }}" method="POST" id="dokterForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_dokter" class="form-label">
                                        Nama Dokter <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nama_dokter') is-invalid @enderror"
                                           id="nama_dokter"
                                           name="nama_dokter"
                                           value="{{ old('nama_dokter', $dokter->nama_dokter) }}"
                                           placeholder="Masukkan nama lengkap dokter"
                                           required>
                                    @error('nama_dokter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spesialisasi" class="form-label">
                                        Spesialisasi <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('spesialisasi') is-invalid @enderror"
                                            id="spesialisasi"
                                            name="spesialisasi"
                                            required>
                                        <option value="">Pilih Spesialisasi</option>
                                        @php
                                            $specializations = [
                                                'Dokter Umum',
                                                'Spesialis Anak',
                                                'Spesialis Kandungan',
                                                'Spesialis Penyakit Dalam',
                                                'Spesialis Bedah',
                                                'Spesialis Jantung',
                                                'Spesialis Saraf',
                                                'Spesialis Mata',
                                                'Spesialis THT',
                                                'Spesialis Kulit',
                                                'Spesialis Jiwa',
                                                'Spesialis Radiologi',
                                                'Spesialis Anestesi',
                                                'Spesialis Orthopedi',
                                                'Spesialis Urologi'
                                            ];
                                        @endphp
                                        @foreach($specializations as $spec)
                                            <option value="{{ $spec }}" {{ old('spesialisasi', $dokter->spesialisasi) == $spec ? 'selected' : '' }}>
                                                {{ $spec }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('spesialisasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_sip" class="form-label">
                                        Nomor SIP <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nomor_sip') is-invalid @enderror"
                                           id="nomor_sip"
                                           name="nomor_sip"
                                           value="{{ old('nomor_sip', $dokter->nomor_sip) }}"
                                           placeholder="Contoh: SIP.123.456.789"
                                           required>
                                    @error('nomor_sip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Surat Izin Praktik dokter</div>
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
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
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
                                    <label for="jadwal_praktek" class="form-label">
                                        Jadwal Praktek <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('jadwal_praktek') is-invalid @enderror"
                                              id="jadwal_praktek"
                                              name="jadwal_praktek"
                                              rows="3"
                                              placeholder="Contoh: Senin-Jumat 08:00-16:00, Sabtu 08:00-12:00"
                                              required>{{ old('jadwal_praktek', $dokter->jadwal_praktek) }}</textarea>
                                    @error('jadwal_praktek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Jadwal praktek dokter per minggu</div>
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
                                               value="{{ old('gaji', $dokter->gaji) }}"
                                               placeholder="Masukkan gaji"
                                               min="0"
                                               step="100000"
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
                                        <p><strong>Nama:</strong> {{ $dokter->nama_dokter }}</p>
                                        <p><strong>Spesialisasi:</strong> {{ $dokter->spesialisasi }}</p>
                                        <p><strong>Nomor SIP:</strong> {{ $dokter->nomor_sip }}</p>
                                        <p><strong>Jenis Kelamin:</strong> {{ $dokter->jenis_kelamin }}</p>
                                        <p><strong>Jadwal:</strong> {{ Str::limit($dokter->jadwal_praktek, 30) }}</p>
                                        <p><strong>Gaji:</strong> Rp {{ number_format($dokter->gaji, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Baru:</h6>
                                        <p><strong>Nama:</strong> <span id="newNama">{{ $dokter->nama_dokter }}</span></p>
                                        <p><strong>Spesialisasi:</strong> <span id="newSpesialisasi">{{ $dokter->spesialisasi }}</span></p>
                                        <p><strong>Nomor SIP:</strong> <span id="newSip">{{ $dokter->nomor_sip }}</span></p>
                                        <p><strong>Jenis Kelamin:</strong> <span id="newGender">{{ $dokter->jenis_kelamin}}</span></p>
                                        <p><strong>Jadwal:</strong> <span id="newJadwal">{{ Str::limit($dokter->jadwal_praktek, 30) }}</span></p>
                                        <p><strong>Gaji:</strong> <span id="newGaji">Rp {{ number_format($dokter->gaji, 0, ',', '.') }}</span></p>
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
                                        <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
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
    const form = document.getElementById('dokterForm');
    const comparisonCard = document.getElementById('comparisonCard');
    const originalData = {
        nama: '{{ $dokter->nama_dokter }}',
        spesialisasi: '{{ $dokter->spesialisasi }}',
        sip: '{{ $dokter->nomor_sip }}',
        gender: '{{ $dokter->jenis_kelamin }}',
        jadwal: `{{ $dokter->jadwal_praktek }}`,
        gaji: {{ $dokter->gaji }}
    };

    // Monitor changes in form
    form.addEventListener('input', function() {
        const currentData = {
            nama: document.getElementById('nama_dokter').value,
            spesialisasi: document.getElementById('spesialisasi').value,
            sip: document.getElementById('nomor_sip').value,
            gender: document.getElementById('jenis_kelamin').value,
            jadwal: document.getElementById('jadwal_praktek').value,
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
        document.getElementById('newSpesialisasi').textContent = newData.spesialisasi;
        document.getElementById('newSip').textContent = newData.sip;
        document.getElementById('newGender').textContent = newData.gender;
        document.getElementById('newJadwal').textContent = newData.jadwal.substring(0, 30) + (newData.jadwal.length > 30 ? '...' : '');
        document.getElementById('newGaji').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newData.gaji);
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const nama = document.getElementById('nama_dokter').value.trim();
        const spesialisasi = document.getElementById('spesialisasi').value;
        const sip = document.getElementById('nomor_sip').value.trim();
        const gender = document.getElementById('jenis_kelamin').value;
        const jadwal = document.getElementById('jadwal_praktek').value.trim();
        const gaji = document.getElementById('gaji').value;

        if (!nama || !spesialisasi || !sip || !gender || !jadwal || !gaji) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }

        if (gaji < 0) {
            e.preventDefault();
            alert('Gaji tidak boleh negatif!');
            return false;
        }

        if (confirm('Apakah Anda yakin ingin menyimpan perubahan data dokter ini?')) {
            // Form will be submitted
        } else {
            e.preventDefault();
        }
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
        document.getElementById('nama_dokter').value = '{{ $dokter->nama_dokter }}';
        document.getElementById('spesialisasi').value = '{{ $dokter->spesialisasi }}';
        document.getElementById('nomor_sip').value = '{{ $dokter->nomor_sip }}';
        document.getElementById('jenis_kelamin').value = '{{ $dokter->jenis_kelamin }}';
        document.getElementById('jadwal_praktek').value = `{{ $dokter->jadwal_praktek }}`;
        document.getElementById('gaji').value = '{{ $dokter->gaji }}';
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

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}
</style>
@endsection