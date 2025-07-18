<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Janji temu terbaru dengan join manual untuk memastikan data lengkap
        $recentAppointments = DB::table('JANJI_TEMU')
            ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->select(
                'JANJI_TEMU.ID_JANJI',
                'JANJI_TEMU.TANGGAL_JANJI',
                'JANJI_TEMU.JAM_JANJI',
                'JANJI_TEMU.KELUHAN',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER',
                'DOKTER.SPESIALISASI'
            )
            ->whereNotNull('JANJI_TEMU.TANGGAL_JANJI')
            ->whereNotNull('PASIEN.NAMA_PASIEN')
            ->whereNotNull('DOKTER.NAMA_DOKTER')
            ->orderBy('JANJI_TEMU.TANGGAL_JANJI', 'desc')
            ->orderBy('JANJI_TEMU.JAM_JANJI', 'desc')
            ->limit(5)
            ->get();

        // Convert hasil query ke object agar kompatibel dengan view
        $recentAppointments = $recentAppointments->map(function ($appointment) {
            return (object) [
                'ID_JANJI' => $appointment->id_janji,
                'TANGGAL_JANJI' => $appointment->tanggal_janji,
                'JAM_JANJI' => $appointment->jam_janji,
                'KELUHAN' => $appointment->keluhan,
                'pasien' => (object) ['NAMA_PASIEN' => $appointment->nama_pasien],
                'dokter' => (object) [
                    'NAMA_DOKTER' => $appointment->nama_dokter,
                    'SPESIALISASI' => $appointment->spesialisasi
                ]
            ];
        });

        return view('home', compact(
            'totalDokter',
            'totalPasien',
            'totalRekamMedis',
            'totalJanjiTemu',
            'totalStaf',
            'recentAppointments',
        ));
    }
}
