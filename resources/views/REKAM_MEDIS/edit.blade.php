@extends('layouts.app')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Edit Data Rekam Medis</h3>
                    <div>
                        <a href="{{ route('rekam_medis.show', $rekamMedis->id_rekam_medis) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
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
                            $currentPasien = $pasien->firstWhere('ID_PASIEN', $rekamMedis->id_pasien);
                        @endphp
                        {{ $currentPasien ? $currentPasien->NAMA_PASIEN : 'N/A' }} | 
                        <strong>Dokter:</strong> 
                        @php
                            $currentDokter = $dokter->firstWhere('ID_DOKTER', $rekamMedis->id_dokter);
                        @endphp
                        {{ $currentDokter ? $currentDokter->NAMA_DOKTER : 'N/A' }} | 
                        <strong>Staf:</strong>
                        @php
                            $currentStaf = $staf->firstWhere('ID_STAF', $rekamMedis->id_staf);
                        @endphp
                        {{ $currentStaf ? $currentStaf->NAMA_STAF : 'Tidak ada' }} |
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d/m/Y') }}
                    </div>

                    <form action="{{ route('rekam_medis.update', $rekamMedis->id_rekam_medis) }}" method="POST" id="rekamMedisForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4">
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
                                            <option value="{{ $p->id_pasien }}" {{ old('id_pasien', $rekamMedis->id_pasien) == $p->id_pasien ? 'selected' : '' }}>
                                                {{ $p->nama_pasien }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
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
                                            <option value="{{ $d->id_dokter }}" {{ old('id_dokter', $rekamMedis->id_dokter) == $d->id_dokter ? 'selected' : '' }}>
                                                {{ $d->nama_dokter }} - {{ $d->spesialisasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_dokter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="id_staf" class="form-label">
                                        Staf (Opsional)
                                    </label>
                                    <select class="form-select @error('id_staf') is-invalid @enderror"
                                            id="id_staf"
                                            name="id_staf">
                                        <option value="">Pilih Staf (Opsional)</option>
                                        @foreach($staf as $s)
                                            <option value="{{ $s->id_staf }}" {{ old('id_staf', $rekamMedis->id_staf) == $s->id_staf ? 'selected' : '' }}>
                                                {{ $s->nama_staf }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_staf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">
                                        Tanggal Pemeriksaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           id="tanggal"
                                           name="tanggal"
                                           value="{{ old('tanggal', $rekamMedis->tanggal) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Tanggal tidak boleh lebih dari hari ini</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="diagnosa" class="form-label">
                                        Diagnosa <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('diagnosa') is-invalid @enderror"
                                           id="diagnosa"
                                           name="diagnosa"
                                           value="{{ old('diagnosa', $rekamMedis->diagnosa) }}"
                                           placeholder="Masukkan diagnosa"
                                           maxlength="1000"
                                           required>
                                    @error('diagnosa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 1000 karakter (<span id="diagnosa-count">{{ strlen($rekamMedis->diagnosa) }}</span>/1000)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hasil_pemeriksaan" class="form-label">
                                        Hasil Pemeriksaan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('hasil_pemeriksaan') is-invalid @enderror"
                                              id="hasil_pemeriksaan"
                                              name="hasil_pemeriksaan"
                                              rows="5"
                                              placeholder="Masukkan hasil pemeriksaan"
                                              maxlength="2000"
                                              required>{{ old('hasil_pemeriksaan', $rekamMedis->hasil_pemeriksaan) }}</textarea>
                                    @error('hasil_pemeriksaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 2000 karakter (<span id="hasil-count">{{ strlen($rekamMedis->hasil_pemeriksaan) }}</span>/2000)</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tindakan" class="form-label">
                                        Tindakan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('tindakan') is-invalid @enderror"
                                              id="tindakan"
                                              name="tindakan"
                                              rows="5"
                                              placeholder="Masukkan tindakan yang dilakukan"
                                              maxlength="1000"
                                              required>{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                                    @error('tindakan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 1000 karakter (<span id="tindakan-count">{{ strlen($rekamMedis->tindakan) }}</span>/1000)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="riwayat_rekam_medis" class="form-label">
                                        Riwayat Rekam Medis (Opsional)
                                    </label>
                                    <textarea class="form-control @error('riwayat_rekam_medis') is-invalid @enderror"
                                              id="riwayat_rekam_medis"
                                              name="riwayat_rekam_medis"
                                              rows="4"
                                              placeholder="Masukkan riwayat rekam medis sebelumnya"
                                              maxlength="2000">{{ old('riwayat_rekam_medis', $rekamMedis->riwayat_rekam_medis) }}</textarea>
                                    @error('riwayat_rekam_medis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 2000 karakter (<span id="riwayat-count">{{ strlen($rekamMedis->riwayat_rekam_medis ?? '') }}</span>/2000)</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="obat" class="form-label">
                                        Obat (Opsional)
                                    </label>
                                    <textarea class="form-control @error('obat') is-invalid @enderror"
                                              id="obat"
                                              name="obat"
                                              rows="4"
                                              placeholder="Masukkan obat yang diberikan"
                                              maxlength="1000">{{ old('obat', $rekamMedis->obat) }}</textarea>
                                    @error('obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maksimal 1000 karakter (<span id="obat-count">{{ strlen($rekamMedis->OBAT ?? '') }}</span>/1000)</div>
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
                                        <p><strong>Staf:</strong> {{ $currentStaf ? $currentStaf->nama_staf : 'Tidak ada' }}</p>
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d/m/Y') }}</p>
                                        <p><strong>Diagnosa:</strong> {{ Str::limit($rekamMedis->diagnosa, 30) }}</p>
                                        <p><strong>Hasil Pemeriksaan:</strong> {{ Str::limit($rekamMedis->hasil_pemeriksaan, 30) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Data Baru:</h6>
                                        <p><strong>Pasien:</strong> <span id="newPasien">{{ $currentPasien ? $currentPasien->nama_pasien : 'N/A' }}</span></p>
                                        <p><strong>Dokter:</strong> <span id="newDokter">{{ $currentDokter ? $currentDokter->nama_dokter : 'N/A' }}</span></p>
                                        <p><strong>Staf:</strong> <span id="newStaf">{{ $currentStaf ? $currentStaf->nama_staf : 'Tidak ada' }}</span></p>
                                        <p><strong>Tanggal:</strong> <span id="newTanggal">{{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d/m/Y') }}</span></p>
                                        <p><strong>Diagnosa:</strong> <span id="newDiagnosa">{{ Str::limit($rekamMedis->diagnosa, 30) }}</span></p>
                                        <p><strong>Hasil Pemeriksaan:</strong> <span id="newHasil">{{ Str::limit($rekamMedis->hasil_pemeriksaan, 30) }}</span></p>
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
                                        <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
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
    const form = document.getElementById('rekamMedisForm');
    const comparisonCard = document.getElementById('comparisonCard');
    
    // Character counters
    const textareas = {
        'hasil_pemeriksaan': 'hasil-count',
        'riwayat_rekam_medis': 'riwayat-count',
        'tindakan': 'tindakan-count',
        'obat': 'obat-count'
    };

    const inputs = {
        'diagnosa': 'diagnosa-count'
    };
    
    const originalData = {
        pasien: {{ $rekamMedis->id_pasien ?? 0 }},
        dokter: {{ $rekamMedis->id_dokter ?? 0 }},
        staf: {{ $rekamMedis->id_staf ?? 0 }},
        tanggal: '{{ $rekamMedis->tanggal }}',
        diagnosa: `{{ $rekamMedis->diagnosa }}`,
        hasil_pemeriksaan: `{{ $rekamMedis->hasil_pemeriksaan }}`,
        riwayat_rekam_medis: `{{ $rekamMedis->riwayat_rekam_medis ?? '' }}`,
        tindakan: `{{ $rekamMedis->tindakan }}`,
        obat: `{{ $rekamMedis->obat ?? '' }}`
    };

    // Data untuk comparison
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

    const stafData = {
        0: 'Tidak ada',
        @foreach($staf as $s)
        {{ $s->id_staf }}: '{{ $s->nama_staf }}',
        @endforeach
    };

    // Character counters untuk textareas
    Object.keys(textareas).forEach(id => {
        const element = document.getElementById(id);
        const counter = document.getElementById(textareas[id]);
        if (element && counter) {
            element.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    });

    // Character counters untuk inputs
    Object.keys(inputs).forEach(id => {
        const element = document.getElementById(id);
        const counter = document.getElementById(inputs[id]);
        if (element && counter) {
            element.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    });

    // Monitor changes in form
    form.addEventListener('input', function() {
        const currentData = {
            pasien: parseInt(document.getElementById('id_pasien').value) || 0,
            dokter: parseInt(document.getElementById('id_dokter').value) || 0,
            staf: parseInt(document.getElementById('id_staf').value) || 0,
            tanggal: document.getElementById('tanggal').value,
            diagnosa: document.getElementById('diagnosa').value,
            hasil_pemeriksaan: document.getElementById('hasil_pemeriksaan').value,
            riwayat_rekam_medis: document.getElementById('riwayat_rekam_medis').value,
            tindakan: document.getElementById('tindakan').value,
            obat: document.getElementById('obat').value
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
        document.getElementById('newStaf').textContent = stafData[newData.staf] || 'Tidak ada';
        
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
        
        // Limit text fields
        const diagnosaText = newData.diagnosa.length > 30 ? 
                           newData.diagnosa.substring(0, 30) + '...' : 
                           newData.diagnosa;
        document.getElementById('newDiagnosa').textContent = diagnosaText || 'N/A';

        const hasilText = newData.hasil_pemeriksaan.length > 30 ? 
                         newData.hasil_pemeriksaan.substring(0, 30) + '...' : 
                         newData.hasil_pemeriksaan;
        document.getElementById('newHasil').textContent = hasilText || 'N/A';
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const pasien = document.getElementById('id_pasien').value;
        const dokter = document.getElementById('id_dokter').value;
        const tanggal = document.getElementById('tanggal').value;
        const diagnosa = document.getElementById('diagnosa').value.trim();
        const hasilPemeriksaan = document.getElementById('hasil_pemeriksaan').value.trim();
        const tindakan = document.getElementById('tindakan').value.trim();

        if (!pasien || !dokter || !tanggal || !diagnosa || !hasilPemeriksaan || !tindakan) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }

        // Validate tanggal tidak boleh lebih dari hari ini
        const today = new Date();
        const selectedDate = new Date(tanggal);
        today.setHours(0, 0, 0, 0);
        selectedDate.setHours(0, 0, 0, 0);

        if (selectedDate > today) {
            e.preventDefault();
            alert('Tanggal pemeriksaan tidak boleh lebih dari hari ini!');
            return false;
        }

        if (confirm('Apakah Anda yakin ingin menyimpan perubahan data rekam medis ini?')) {
            // Form will be submitted
        } else {
            e.preventDefault();
        }
    });
});

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form ke data awal?')) {
        document.getElementById('id_pasien').value = '{{ $rekamMedis->id_pasien }}';
        document.getElementById('id_dokter').value = '{{ $rekamMedis->id_dokter }}';
        document.getElementById('id_staf').value = '{{ $rekamMedis->id_staf ?? "" }}';
        document.getElementById('tanggal').value = '{{ $rekamMedis->tanggal }}';
        document.getElementById('diagnosa').value = `{{ $rekamMedis->diagnosa }}`;
        document.getElementById('hasil_pemeriksaan').value = `{{ $rekamMedis->hasil_pemeriksaan }}`;
        document.getElementById('riwayat_rekam_medis').value = `{{ $rekamMedis->riwayat_rekam_medis ?? '' }}`;
        document.getElementById('tindakan').value = `{{ $rekamMedis->tindakan }}`;
        document.getElementById('obat').value = `{{ $rekamMedis->obat ?? '' }}`;
        
        document.getElementById('comparisonCard').style.display = 'none';
        
        // Reset character counters
        document.getElementById('diagnosa-count').textContent = '{{ strlen($rekamMedis->diagnosa) }}';
        document.getElementById('hasil-count').textContent = '{{ strlen($rekamMedis->hasil_pemeriksaan) }}';
        document.getElementById('riwayat-count').textContent = '{{ strlen($rekamMedis->riwayat_rekam_medis ?? '') }}';
        document.getElementById('tindakan-count').textContent = '{{ strlen($rekamMedis->tindakan) }}';
        document.getElementById('obat-count').textContent = '{{ strlen($rekamMedis->obat ?? '') }}';
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

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endsection