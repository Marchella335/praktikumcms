<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PASIEN;
use Carbon\Carbon;

class PASIENController extends Controller
{
    public function index()
    {
        $pasien = DB::table('PASIEN')->orderBy('ID_PASIEN', 'asc')->get();
        return view('PASIEN.index', compact('pasien'));
    }

    public function show($id)
    {
        $pasien = DB::table('PASIEN')->where('ID_PASIEN', $id)->first();
        
        if (!$pasien) {
            return redirect()->route('pasien.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('PASIEN.show', compact('pasien'));
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
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data pasien.');
        }
    }

    public function edit($id)
    {
        $pasien = DB::table('PASIEN')->where('ID_PASIEN', $id)->first();

        if (!$pasien) {
            return redirect()->route('pasien.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('PASIEN.edit', compact('pasien'));
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
            DB::table('PASIEN')->where('ID_PASIEN', $id)->update([
                'NAMA_PASIEN' => $request->nama_pasien,
                'ALAMAT' => $request->alamat,
                'NOMOR_TELEPON' => $request->nomor_telepon,
                'USIA' => $request->usia,
                'JENIS_KELAMIN' => $request->jenis_kelamin,
                'STATUS_PASIEN' => $request->status_pasien,
            ]);

            return redirect()->route('pasien.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating pasien: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data pasien.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('PASIEN')->where('ID_PASIEN', $id)->delete();
            return redirect()->route('pasien.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting pasien: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data pasien.');
        }
    }
}