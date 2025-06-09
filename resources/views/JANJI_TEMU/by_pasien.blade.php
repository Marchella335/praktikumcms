@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Janji Temu Pasien</h5>
                <small>{{ $pasien->nama_pasien }}</small>
            </div>
            <a href="{{ route('janji_temu.index') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            @if($janjiTemu->isEmpty())
                <div class="alert alert-warning text-center">Tidak ada janji temu untuk pasien ini.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>ID Janji</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Dokter</th>
                                <th>Keluhan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($janjiTemu as $janji)
                            <tr>
                                <td class="text-center">{{ $janji->id_janji }}</td>
                                <td>{{ \Carbon\Carbon::parse($janji->tanggal_janji)->format('d-m-Y') }}</td>
                                <td>{{ $janji->jam_janji }}</td>
                                <td>{{ $janji->nama_dokter }}</td>
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
