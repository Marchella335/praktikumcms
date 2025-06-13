@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Rekam Medis Berdasarkan Pasien</h2>

    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Nama Pasien:</strong> {{ $pasien->nama_pasien ?? 'Tidak tersedia' }}</p>
        </div>
    </div>

    <table class="table table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>ID Rekam Medis</th>
                <th>Hasil Pemeriksaan</th>
                <th>Riwayat Rekam Medis</th>
                <th>ID Staf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $data)
                <tr>
                    <td>{{ $data->id_rekam_medis }}</td>
                    <td>{{ $data->hasil_pemeriksaan }}</td>
                    <td>{{ $data->riwayat_rekam_medis }}</td>
                    <td>{{ $data->id_staf }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
