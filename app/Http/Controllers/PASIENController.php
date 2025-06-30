<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PASIEN;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PASIENController extends Controller
{
    public function index()
    {
         $pasien = DB::table('PASIEN')->orderBy('ID_PASIEN', 'asc')->get();

    // Total pasien
    $totalPasien = $pasien->count();

    // jumlah Laki-laki dan Perempuan
    $jumlahLaki = $pasien->filter(function ($p) {
        return strtolower(trim($p->jenis_kelamin)) === 'laki-laki';
    })->count();

    $jumlahPerempuan = $pasien->filter(function ($p) {
        return strtolower(trim($p->jenis_kelamin)) === 'perempuan';
    })->count();

    return view('PASIEN.index', compact(
        'pasien',
        'totalPasien',
        'jumlahLaki',
        'jumlahPerempuan',
    ));
    }

    // Method show menggunakan findOrFail 
    public function show($id)
    {
        try {
            // Menggunakan findOrFail - akan otomatis throw 404 jika tidak ditemukan
            $pasien = PASIEN::findOrFail($id);
            return view('PASIEN.show', compact('pasien'));
        } catch (ModelNotFoundException $e) {
            // Handle jika data tidak ditemukan
            return redirect()->route('pasien.index')->with('error', 'Data pasien dengan ID ' . $id . ' tidak ditemukan.');
        }
    }

    public function create()
    {
        return view('PASIEN.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NAMA_PASIEN' => 'required|string|max:255',
            'ALAMAT' => 'required|string|max:500',
            'NOMOR_TELEPON' => 'required|string|max:20',
            'USIA' => 'required|integer|min:0|max:150',
            'JENIS_KELAMIN' => 'required|in:Laki-laki,Perempuan',
            'STATUS_PASIEN' => 'required|string|max:100',
        ]);

        try {
            DB::insert("
                INSERT INTO PASIEN (NAMA_PASIEN, ALAMAT, NOMOR_TELEPON, USIA, JENIS_KELAMIN, STATUS_PASIEN)
                VALUES (:nama, :alamat, :telepon, :usia, :jenis_kelamin, :status)
            ", [
                'nama' => $request->NAMA_PASIEN,
                'alamat' => $request->ALAMAT,
                'telepon' => $request->NOMOR_TELEPON,
                'usia' => $request->USIA,
                'jenis_kelamin' => $request->JENIS_KELAMIN,
                'status' => $request->STATUS_PASIEN,
            ]);

            return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating pasien: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data pasien: ' . $e->getMessage());
        }
    }

    // Method edit menggunakan findOrFail 
    public function edit($id)
    {
        try {
            // Menggunakan findOrFail untuk error handling otomatis
            $pasien = PASIEN::findOrFail($id);
            return view('PASIEN.edit', compact('pasien'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pasien.index')->with('error', 'Data pasien dengan ID ' . $id . ' tidak ditemukan untuk diedit.');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'nomor_telepon' => 'required|string|max:20',
            'usia' => 'required|integer|min:0|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_pasien' => 'required|string|max:100',
        ]);

        try {
            // Cek apakah data exists dengan findOrFail
            $pasien = PASIEN::findOrFail($id);
            
            DB::table('PASIEN')->where('ID_PASIEN', $id)->update([
                'NAMA_PASIEN' => $request->nama_pasien,
                'ALAMAT' => $request->alamat,
                'NOMOR_TELEPON' => $request->nomor_telepon,
                'USIA' => $request->usia,
                'JENIS_KELAMIN' => $request->jenis_kelamin,
                'STATUS_PASIEN' => $request->status_pasien,
            ]);

            return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pasien.index')->with('error', 'Data pasien dengan ID ' . $id . ' tidak ditemukan untuk diupdate.');
        } catch (\Exception $e) {
            Log::error('Error updating pasien: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data pasien: ' . $e->getMessage());
        }
    }

    // Method destroy menggunakan findOrFail 
    public function destroy($id)
    {
        try {
            // Cek apakah data exists dengan findOrFail
            $pasien = PASIEN::findOrFail($id);
            
            DB::table('PASIEN')->where('ID_PASIEN', $id)->delete();
            return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pasien.index')->with('error', 'Data pasien dengan ID ' . $id . ' tidak ditemukan untuk dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting pasien: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data pasien: ' . $e->getMessage());
        }
    }


    // Method khusus untuk demo error handler dengan firstOrFail
    public function findByEmail($email)
    {
        try {
            $pasien = PASIEN::where('NAMA_PASIEN', $email)->firstOrFail();
            return response()->json(['data' => $pasien]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pasien dengan nama ' . $email . ' tidak ditemukan'], 404);
        }
    }

    // Method untuk testing error handler
    public function testErrorHandler($id)
    {
        try {
            $pasien = PASIEN::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $pasien
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data dengan ID ' . $id . ' tidak ditemukan',
                'error_type' => 'ModelNotFoundException'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'error_type' => 'GeneralException'
            ], 500);
        }
    }
}