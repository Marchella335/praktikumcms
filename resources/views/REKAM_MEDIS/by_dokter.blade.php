@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Rekam Medis Berdasarkan Dokter</h2>

        <div>
                <h5 class="mb-0">Janji Temu Dokter</h5>
                <small>{{ $dokter->nama_dokter }} — {{ $dokter->spesialisasi }}</small>
            </div>
            <a href="{{ route('janji_temu.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

    <table class="table table-bordered mt-4">
        <thead class="table-primary">
            <tr>
                <th>ID Rekam Medis</th>
                <th>Hasil Pemeriksaan</th>
                <th>Riwayat Rekam Medis</th>
                <th>ID Pasien</th>
                <th>ID Staf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $data)
                <tr>
                    <td>{{ $data->id_rekam_medis }}</td>
                    <td>{{ $data->hasil_pemeriksaan }}</td>
                    <td>{{ $data->riwayat_rekam_medis }}</td>
                    <td>{{ $data->id_pasien }}</td>
                    <td>{{ $data->id_staf }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
