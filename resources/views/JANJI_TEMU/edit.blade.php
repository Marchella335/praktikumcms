@extends('layouts.app')

@section('title', 'Edit Janji Temu')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Data Janji Temu</h3>
                    <div>
                        <a href="{{ route('janji_temu.show', $janjiTemu->id_janji) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('janji_temu.index') }}" class="btn btn-secondary">
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
                        <strong>Pasien:</strong> 
                        @php
                            $currentPasien = $pasien->firstWhere('id_pasien', $janjiTemu->id_pasien);
                        @endphp
                        {{ $currentPasien ? $currentPasien->nama_pasien : 'N/A' }} | 
                        <strong>Dokter:</strong> 
                        @php
                            $currentDokter = $dokter->firstWhere('id_pasien', $janjiTemu->id_dokter);
                        @endphp
                        {{ $currentDokter ? $currentDokter->nama_dokter : 'N/A' }} | 
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y') }} | 
                        <strong>Jam:</strong> {{ \Carbon\Carbon::parse($janjiTemu->jam_janji)->format('H:i') }}
                    </div>

                    <form action="{{ route('janji_temu.update', $janjiTemu->id_janji) }}" method="POST" id="janjiTemuForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_pasien" class="form-label">
                                        Pasien <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('id_pasien') is-invalid @enderror"
                                            id="id_pasien"
                                            name="id_pasien"
                                            required>
                                        <option value="">Pilih Pasien</option>
                                        @foreach($pasien as $p)
                                            <option value="{{ $p->id_pasien }}" {{ old('id_pasien', $janjiTemu->id_pasien) == $p->id_pasien ? 'selected' : '' }}>
                                                {{ $p->nama_pasien }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_dokter" class="form-label">
                                        Dokter <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('id_dokter') is-invalid @enderror"
                                            id="id_dokter"
                                            name="id_dokter"
                                            required>
                                        <option value="">Pilih Dokter</option>
                                        @foreach($dokter as $d)
                                            <option value="{{ $d->id_dokter }}" {{ old('id_dokter', $janjiTemu->id_dokter) == $d->id_dokter ? 'selected' : '' }}>
                                                {{ $d->nama_dokter }} - {{ $d->spesialisasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_dokter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_janji" class="form-label">
                                        Tanggal Janji <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('tanggal_janji') is-invalid @enderror"
                                           id="tanggal_janji"
                                           name="tanggal_janji"
                                           value="{{ old('tanggal_janji', $janjiTemu->tanggal_janji) }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('tanggal_janji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tanggal tidak boleh sebelum hari ini</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jam_janji" class="form-label">
                                        Jam Janji <span class="text-danger">*</span>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('jam_janji') is-invalid @enderror"
                                           id="jam_janji"
                                           name="jam_janji"
                                           value="{{ old('jam_janji', \Carbon\Carbon::parse($janjiTemu->jam_janji)->format('H:i')) }}"
                                           required>
                                    @error('jam_janji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format 24 jam (HH:MM)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="keluhan" class="form-label">
                                        Keluhan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('keluhan') is-invalid @enderror"
                                              id="keluhan"
                                              name="keluhan"
                                              rows="4"
                                              placeholder="Masukkan keluhan atau gejala yang dialami pasien"
                                              maxlength="1000"
                                              required>{{ old('keluhan', $janjiTemu->keluhan) }}</textarea>
                                    @error('keluhan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 1000 karakter (<span id="char-count">{{ strlen($janjiTemu->keluhan) }}</span>/1000)</div>
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
                                        <p><strong>Pasien:</strong> {{ $currentPasien ? $currentPasien->nama_pasien : 'N/A' }}</p>
                                        <p><strong>Dokter:</strong> {{ $currentDokter ? $currentDokter->nama_dokter : 'N/A' }}</p>
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y') }}</p>
                                        <p><strong>Jam:</strong> {{ \Carbon\Carbon::parse($janjiTemu->jam_janji)->format('H:i') }}</p>
                                        <p><strong>Keluhan:</strong> {{ Str::limit($janjiTemu->keluhan, 50) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Baru:</h6>
                                        <p><strong>Pasien:</strong> <span id="newPasien">{{ $currentPasien ? $currentPasien->nama_pasien : 'N/A' }}</span></p>
                                        <p><strong>Dokter:</strong> <span id="newDokter">{{ $currentDokter ? $currentDokter->nama_dokter : 'N/A' }}</span></p>
                                        <p><strong>Tanggal:</strong> <span id="newTanggal">{{ \Carbon\Carbon::parse($janjiTemu->tanggal_janji)->format('d/m/Y') }}</span></p>
                                        <p><strong>Jam:</strong> <span id="newJam">{{ \Carbon\Carbon::parse($janjiTemu->jam_janji)->format('H:i') }}</span></p>
                                        <p><strong>Keluhan:</strong> <span id="newKeluhan">{{ Str::limit($janjiTemu->keluhan, 50) }}</span></p>
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
                                        <a href="{{ route('janji_temu.index') }}" class="btn btn-secondary">
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
    const form = document.getElementById('janjiTemuForm');
    const comparisonCard = document.getElementById('comparisonCard');
    const keluhanTextarea = document.getElementById('keluhan');
    const charCount = document.getElementById('char-count');
    
    const originalData = {
        pasien: {{ $janjiTemu->id_pasien }},
        dokter: {{ $janjiTemu->id_dokter }},
        tanggal: '{{ $janjiTemu->tanggal_janji }}',
        jam: '{{ \Carbon\Carbon::parse($janjiTemu->jam_janji)->format("H:i") }}',
        keluhan: `{{ $janjiTemu->keluhan }}`
    };

    // Pasien dan Dokter data untuk comparison
    const pasienData = {
        @foreach($pasien as $p)
        {{ $p->id_pasien }}: '{{ $p->nama_pasien }}',
        @endforeach
    };

    const dokterData = {
        @foreach($dokter as $d)
        {{ $d->id_dokter }}: '{{ $d->nama_dokter }}',
        @endforeach
    };

    // Character counter for keluhan
    keluhanTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    // Monitor changes in form
    form.addEventListener('input', function() {
        const currentData = {
            pasien: parseInt(document.getElementById('id_pasien').value) || 0,
            dokter: parseInt(document.getElementById('id_dokter').value) || 0,
            tanggal: document.getElementById('tanggal_janji').value,
            jam: document.getElementById('jam_janji').value,
            keluhan: document.getElementById('keluhan').value
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
        document.getElementById('newPasien').textContent = pasienData[newData.pasien] || 'N/A';
        document.getElementById('newDokter').textContent = dokterData[newData.dokter] || 'N/A';
        
        // Format tanggal
        if (newData.tanggal) {
            const date = new Date(newData.tanggal);
            const formattedDate = date.getDate().toString().padStart(2, '0') + '/' + 
                                (date.getMonth() + 1).toString().padStart(2, '0') + '/' + 
                                date.getFullYear();
            document.getElementById('newTanggal').textContent = formattedDate;
        } else {
            document.getElementById('newTanggal').textContent = 'N/A';
        }
        
        document.getElementById('newJam').textContent = newData.jam || 'N/A';
        
        // Limit keluhan text
        const keluhanText = newData.keluhan.length > 50 ? 
                           newData.keluhan.substring(0, 50) + '...' : 
                           newData.keluhan;
        document.getElementById('newKeluhan').textContent = keluhanText || 'N/A';
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const pasien = document.getElementById('id_pasien').value;
        const dokter = document.getElementById('id_dokter').value;
        const tanggal = document.getElementById('tanggal_janji').value;
        const jam = document.getElementById('jam_janji').value;
        const keluhan = document.getElementById('keluhan').value.trim();

        if (!pasien || !dokter || !tanggal || !jam || !keluhan) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }

        // Validate tanggal tidak boleh sebelum hari ini
        const today = new Date();
        const selectedDate = new Date(tanggal);
        today.setHours(0, 0, 0, 0);
        selectedDate.setHours(0, 0, 0, 0);

        if (selectedDate < today) {
            e.preventDefault();
            alert('Tanggal janji tidak boleh sebelum hari ini!');
            return false;
        }

        if (confirm('Apakah Anda yakin ingin menyimpan perubahan data janji temu ini?')) {
            // Form will be submitted
        } else {
            e.preventDefault();
        }
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
        document.getElementById('id_pasien').value = '{{ $janjiTemu->id_pasien }}';
        document.getElementById('id_dokter').value = '{{ $janjiTemu->id_dokter }}';
        document.getElementById('tanggal_janji').value = '{{ $janjiTemu->tanggal_janji }}';
        document.getElementById('jam_janji').value = '{{ \Carbon\Carbon::parse($janjiTemu->jam_janji)->format("H:i") }}';
        document.getElementById('keluhan').value = `{{ $janjiTemu->keluhan }}`;
        document.getElementById('comparisonCard').style.display = 'none';
        document.getElementById('char-count').textContent = '{{ strlen($janjiTemu->keluhan) }}';
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

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}
</style>
@endsection