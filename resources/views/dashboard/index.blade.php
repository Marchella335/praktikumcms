@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard</h2>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h5>
                <p class="card-text">Anda berhasil login ke sistem.</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                
                <!-- Konten dashboard Anda bisa ditambahkan disini -->
            </div>
        </div>
    </div>
</div>
@endsection