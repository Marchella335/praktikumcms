@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Janji Temu Dokter</h5>
                <small>{{ $dokter->nama_dokter }} — {{ $dokter->spesialisasi }}</small>
            </div>
            <a href="{{ route('janji_temu.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

        <div class="card-body bg-light">
            @if($janjiTemu->isEmpty())
                <div class="alert alert-warning text-center">
                    Tidak ada janji temu untuk dokter ini.
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ID Janji</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($janjiTemu as $janji)
                        <tr>
                            <td class="text-center">{{ $janji->id_janji }}</td>
                            <td>{{ \Carbon\Carbon::parse($janji->tanggal_janji)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($janji->jam_janji)->format('H:i') }}</td>
                            <td>{{ $janji->nama_pasien }}</td>
                            <td>{{ $janji->keluhan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
