<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\JANJI_TEMU;
use App\Models\PASIEN;
use App\Models\DOKTER;
use Carbon\Carbon;

class JANJI_TEMUController extends Controller
{
    public function index()
    {
        $janjiTemu = DB::table('JANJI_TEMU')
            ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->select(
                'JANJI_TEMU.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER'
            )
            ->orderBy('JANJI_TEMU.ID_JANJI', 'asc')
            ->get();
        
        return view('JANJI_TEMU.index', compact('janjiTemu'));
    }

    // Method show menggunakan findOrFail
    public function show($id)
    {
        try {
            // Menggunakan Model JANJI_TEMU dengan findOrFail
            $janjiTemu = JANJI_TEMU::findOrFail($id);
            
            // Memuat detail dengan join untuk tampilan
            $janjiTemuDetail = DB::table('JANJI_TEMU')
                ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->select(
                    'JANJI_TEMU.*',
                    'PASIEN.NAMA_PASIEN',
                    'PASIEN.NOMOR_TELEPON',
                    'DOKTER.NAMA_DOKTER',
                    'DOKTER.SPESIALISASI'
                )
                ->where('JANJI_TEMU.ID_JANJI', $id)
                ->first();

            return view('JANJI_TEMU.show', ['janjiTemu' => $janjiTemuDetail]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika data tidak ditemukan, Laravel otomatis throw 404
            // Tapi kita bisa custom pesan errornya
            return redirect()->route('janji_temu.index')->with('error', 'Data janji temu dengan ID ' . $id . ' tidak ditemukan.');
        }
    }

    public function create()
    {
        $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();
        $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->orderBy('NAMA_DOKTER')->get();
        
        return view('JANJI_TEMU.create', compact('pasien', 'dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_PASIEN' => 'required|integer|exists:PASIEN,ID_PASIEN',
            'ID_DOKTER' => 'required|integer|exists:DOKTER,ID_DOKTER',
            'TANGGAL_JANJI' => 'required|date|after_or_equal:today',
            'JAM_JANJI' => 'required|date_format:H:i',
            'KELUHAN' => 'required|string|max:1000',
        ]);

        try {
            // Cek apakah dokter sudah ada janji pada tanggal dan jam yang sama
            $existingAppointment = DB::table('JANJI_TEMU')
                ->where('ID_DOKTER', $request->ID_DOKTER)
                ->where('TANGGAL_JANJI', $request->TANGGAL_JANJI)
                ->where('JAM_JANJI', $request->JAM_JANJI)
                ->first();

            if ($existingAppointment) {
                return back()->with('error', 'Dokter sudah memiliki janji pada tanggal dan jam tersebut.');
            }

            DB::insert("
                INSERT INTO JANJI_TEMU (ID_PASIEN, ID_DOKTER, TANGGAL_JANJI, JAM_JANJI, KELUHAN)
                VALUES (:id_pasien, :id_dokter, :tanggal_janji, :jam_janji, :keluhan)
            ", [
                'id_pasien' => $request->ID_PASIEN,
                'id_dokter' => $request->ID_DOKTER,
                'tanggal_janji' => $request->TANGGAL_JANJI,
                'jam_janji' => $request->JAM_JANJI,
                'keluhan' => $request->KELUHAN,
            ]);

            return redirect()->route('janji_temu.index')->with('success', 'Data janji temu berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating janji temu: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data janji temu.');
        }
    }

    // Method edit menggunakan findOrFail 
    public function edit($id)
    {
        try {
            $janjiTemu = JANJI_TEMU::findOrFail($id);
            $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();
            $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->orderBy('NAMA_DOKTER')->get();
            
            return view('JANJI_TEMU.edit', compact('janjiTemu', 'pasien', 'dokter'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('janji_temu.index')->with('error', 'Data janji temu tidak ditemukan untuk diedit.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasien' => 'required|integer|exists:PASIEN,ID_PASIEN',
            'id_dokter' => 'required|integer|exists:DOKTER,ID_DOKTER',
            'tanggal_janji' => 'required|date|after_or_equal:today',
            'jam_janji' => 'required|date_format:H:i',
            'keluhan' => 'required|string|max:1000',
        ]);

        try {
            // Cek dulu apakah data exists menggunakan findOrFail
            $janjiTemu = JANJI_TEMU::findOrFail($id);

            // Cek apakah dokter sudah ada janji pada tanggal dan jam yang sama (kecuali janji yang sedang diedit)
            $existingAppointment = DB::table('JANJI_TEMU')
                ->where('ID_DOKTER', $request->id_dokter)
                ->where('TANGGAL_JANJI', $request->tanggal_janji)
                ->where('JAM_JANJI', $request->jam_janji)
                ->where('ID_JANJI', '!=', $id)
                ->first();

            if ($existingAppointment) {
                return back()->with('error', 'Dokter sudah memiliki janji pada tanggal dan jam tersebut. Silakan pilih waktu lain.');
            }

            DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->update([
                'ID_PASIEN' => $request->id_pasien,
                'ID_DOKTER' => $request->id_dokter,
                'TANGGAL_JANJI' => $request->tanggal_janji,
                'JAM_JANJI' => $request->jam_janji,
                'KELUHAN' => $request->keluhan,
            ]);

            return redirect()->route('janji_temu.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('janji_temu.index')->with('error', 'Data janji temu tidak ditemukan untuk diupdate.');
        } catch (\Exception $e) {
            Log::error('Error updating janji temu: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data janji temu.');
        }
    }

    public function destroy($id)
    {
        try {
            // Menggunakan findOrFail untuk memastikan data ada sebelum dihapus
            $janjiTemu = JANJI_TEMU::findOrFail($id);
            
            DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->delete();
            return redirect()->route('janji_temu.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('janji_temu.index')->with('error', 'Data janji temu tidak ditemukan untuk dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting janji temu: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data janji temu.');
        }
    }

    // Method tambahan untuk demonstrasi pencarian berdasarkan pasien
    public function findByPasien($idPasien)
    {
        try {
            // Menggunakan firstOrFail untuk mencari berdasarkan pasien
            $pasien = PASIEN::findOrFail($idPasien);
            
            $janjiTemu = DB::table('JANJI_TEMU')
                ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->select(
                    'JANJI_TEMU.*',
                    'PASIEN.NAMA_PASIEN',
                    'DOKTER.NAMA_DOKTER'
                )
                ->where('JANJI_TEMU.ID_PASIEN', $idPasien)
                ->orderBy('JANJI_TEMU.TANGGAL_JANJI', 'desc')
                ->get();

            return view('JANJI_TEMU.by_pasien', compact('janjiTemu', 'pasien'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('janji_temu.index')->with('error', 'Pasien dengan ID "' . $idPasien . '" tidak ditemukan.');
        }
    }

    // Method tambahan untuk demonstrasi try-catch manual
    public function findByDokterAlternative($idDokter)
    {
        try {
            $dokter = DB::table('DOKTER')->where('ID_DOKTER', $idDokter)->first();
            
            if (!$dokter) {
                throw new \Exception('Dokter dengan ID tersebut tidak ditemukan');
            }

            $janjiTemu = DB::table('JANJI_TEMU')
                ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->select(
                    'JANJI_TEMU.*',
                    'PASIEN.NAMA_PASIEN',
                    'DOKTER.NAMA_DOKTER'
                )
                ->where('JANJI_TEMU.ID_DOKTER', $idDokter)
                ->orderBy('JANJI_TEMU.TANGGAL_JANJI', 'desc')
                ->get();

            return view('JANJI_TEMU.by_dokter', compact('janjiTemu', 'dokter'));
        } catch (\Exception $e) {
            Log::error('Error finding janji temu by dokter: ' . $e->getMessage());
            return redirect()->route('janji_temu.index')->with('error', 'Dokter dengan ID "' . $idDokter . '" tidak ditemukan.');
        }
    }
    // Add these methods to your JANJI_TEMUController class

public function byPasien($idPasien)
{
    try {
        // Menggunakan findOrFail untuk memastikan pasien ada
        $pasien = PASIEN::findOrFail($idPasien);
        
        $janjiTemu = DB::table('JANJI_TEMU')
            ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->select(
                'JANJI_TEMU.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER'
            )
            ->where('JANJI_TEMU.ID_PASIEN', $idPasien)
            ->orderBy('JANJI_TEMU.TANGGAL_JANJI', 'desc')
            ->get();

        return view('JANJI_TEMU.by_pasien', compact('janjiTemu', 'pasien'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('janji_temu.index')->with('error', 'Pasien dengan ID "' . $idPasien . '" tidak ditemukan.');
    }
}

public function byDokter($idDokter)
{
    try {
        // Menggunakan findOrFail untuk memastikan dokter ada
        $dokter = DOKTER::findOrFail($idDokter);
        
        $janjiTemu = DB::table('JANJI_TEMU')
            ->join('PASIEN', 'JANJI_TEMU.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'JANJI_TEMU.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->select(
                'JANJI_TEMU.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER'
            )
            ->where('JANJI_TEMU.ID_DOKTER', $idDokter)
            ->orderBy('JANJI_TEMU.TANGGAL_JANJI', 'desc')
            ->get();

        return view('JANJI_TEMU.by_dokter', compact('janjiTemu', 'dokter'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('janji_temu.index')->with('error', 'Dokter dengan ID "' . $idDokter . '" tidak ditemukan.');
    } catch (\Exception $e) {
        Log::error('Error finding janji temu by dokter: ' . $e->getMessage());
        return redirect()->route('janji_temu.index')->with('error', 'Terjadi kesalahan saat mencari data janji temu.');
    }
}
}