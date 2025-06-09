<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DOKTER;
use App\Models\PASIEN;
use App\Models\REKAM_MEDIS;
use App\Models\JANJI_TEMU;
use App\Models\STAF;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $totalDokter = DOKTER::count();
        $totalPasien = PASIEN::count();
        $totalRekamMedis = REKAM_MEDIS::count();
        $totalJanjiTemu = JANJI_TEMU::count();
        $totalStaf = STAF::count();

        // Janji temu terbaru
        $recentAppointments = JANJI_TEMU::with(['pasien', 'dokter'])
            ->orderBy('TANGGAL_JANJI', 'desc')
            ->limit(5)
            ->get();

        // Spesialisasi dokter
        $dokterSpesialisasi = DOKTER::select('SPESIALISASI')
            ->distinct()
            ->get()
            ->pluck('SPESIALISASI');

        // Kirim data ke view home.blade.php
        return view('home', compact(
            'totalDokter',
            'totalPasien', 
            'totalRekamMedis',
            'totalJanjiTemu',
            'totalStaf',
            'recentAppointments',
            'dokterSpesialisasi'
        ));
    }
}
