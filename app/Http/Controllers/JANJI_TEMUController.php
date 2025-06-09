<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JANJI_TEMU;
use App\Models\PASIEN;
use App\Models\DOKTER;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function show($id)
    {
        $janjiTemu = DB::table('JANJI_TEMU')
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
        
        if (!$janjiTemu) {
            return redirect()->route('janji_temu.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('JANJI_TEMU.show', compact('janjiTemu'));
    }

    public function create()
    {
        $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->get();
        $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->get();
        
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

            return redirect()->route('janji_temu.index')->with('success', 'Janji temu berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error creating janji temu: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat janji temu.');
        }
    }

    public function edit($id)
    {
        $janjiTemu = DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->first();
        
        if (!$janjiTemu) {
            return redirect()->route('janji_temu.index')->with('error', 'Data tidak ditemukan.');
        }

        $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();
        $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->orderBy('NAMA_DOKTER')->get();

        return view('JANJI_TEMU.edit', compact('janjiTemu', 'pasien', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasien' => 'required|integer|exists:PASIEN,ID_PASIEN',
            'id_dokter' => 'required|integer|exists:DOKTER,ID_DOKTER',
            'tanggal_janji' => 'required|date|after_or_equal:today',
            'jam_janji' => 'required|date_format:H:i',
            'keluhan' => 'required|string|max:1000',
        ], [
            'id_pasien.required' => 'Pasien harus dipilih.',
            'id_pasien.exists' => 'Pasien yang dipilih tidak valid.',
            'id_dokter.required' => 'Dokter harus dipilih.',
            'id_dokter.exists' => 'Dokter yang dipilih tidak valid.',
            'tanggal_janji.required' => 'Tanggal janji harus diisi.',
            'tanggal_janji.after_or_equal' => 'Tanggal janji tidak boleh sebelum hari ini.',
            'jam_janji.required' => 'Jam janji harus diisi.',
            'jam_janji.date_format' => 'Format jam janji tidak valid (HH:MM).',
            'keluhan.required' => 'Keluhan harus diisi.',
            'keluhan.max' => 'Keluhan maksimal 1000 karakter.',
        ]);

        try {
            // Cek apakah dokter sudah ada janji pada tanggal dan jam yang sama (kecuali janji yang sedang diedit)
            $existingAppointment = DB::table('JANJI_TEMU')
                ->where('ID_DOKTER', $request->id_dokter)
                ->where('TANGGAL_JANJI', $request->tanggal_janji)
                ->where('JAM_JANJI', $request->jam_janji)
                ->where('ID_JANJI', '!=', $id)
                ->first();

            if ($existingAppointment) {
                return back()->withInput()->with('error', 'Dokter sudah memiliki janji pada tanggal dan jam tersebut. Silakan pilih waktu lain.');
            }

            // Get old data for logging
            $oldData = DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->first();
            
            // Update data
            $updated = DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->update([
                'ID_PASIEN' => $request->id_pasien,
                'ID_DOKTER' => $request->id_dokter,
                'TANGGAL_JANJI' => $request->tanggal_janji,
                'JAM_JANJI' => $request->jam_janji . ':00', // Add seconds
                'KELUHAN' => trim($request->keluhan),
            ]);

            if ($updated) {
                // Log the update
                Log::info('Janji temu updated successfully', [
                    'id' => $id,
                    'old_data' => $oldData,
                    'new_data' => [
                        'ID_PASIEN' => $request->id_pasien,
                        'ID_DOKTER' => $request->id_dokter,
                        'TANGGAL_JANJI' => $request->tanggal_janji,
                        'JAM_JANJI' => $request->jam_janji,
                        'KELUHAN' => $request->keluhan,
                    ]
                ]);

                return redirect()->route('janji_temu.index')->with('success', 'Janji temu berhasil diperbarui.');
            } else {
                return back()->withInput()->with('error', 'Tidak ada perubahan data yang disimpan.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating janji temu: ' . $e->getMessage(), [
                'id' => $id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui janji temu. Silakan coba lagi.');
        }
    }
    public function destroy($id)
    {
        try {
            DB::table('JANJI_TEMU')->where('ID_JANJI', $id)->delete();
            return redirect()->route('janji_temu.index')->with('success', 'Janji temu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting janji temu: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus janji temu.');
        }
    }

    // Method tambahan untuk menampilkan janji temu berdasarkan pasien
    public function byPasien($idPasien)
    {
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

        $pasien = DB::table('PASIEN')->where('ID_PASIEN', $idPasien)->first();

        return view('JANJI_TEMU.by_pasien', compact('janjiTemu', 'pasien'));
    }

    // Method tambahan untuk menampilkan janji temu berdasarkan dokter
    public function byDokter($idDokter)
    {
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

        $dokter = DB::table('DOKTER')->where('ID_DOKTER', $idDokter)->first();

        return view('JANJI_TEMU.by_dokter', compact('janjiTemu', 'dokter'));
    }
}