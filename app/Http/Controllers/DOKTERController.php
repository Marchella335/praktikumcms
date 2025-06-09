<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\DOKTER;
use Carbon\Carbon;

class DOKTERController extends Controller
{
    public function index()
    {
        $dokter = DB::table('DOKTER')->orderBy('ID_DOKTER', 'asc')->get();
        return view('DOKTER.index', compact('dokter'));
    }

    public function show($id)
    {
        $dokter = DB::table('DOKTER')->where('ID_DOKTER', $id)->first();
        
        if (!$dokter) {
            return redirect()->route('dokter.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('DOKTER.show', compact('dokter'));
    }

    public function create()
    {
        return view('DOKTER.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NAMA_DOKTER' => 'required|string|max:255',
            'SPESIALISASI' => 'required|string|max:255',
            'NOMOR_SIP' => 'required|string|max:50',
            'JADWAL_PRAKTEK' => 'required|string|max:255',
            'JENIS_KELAMIN' => 'required|in:Laki-laki,Perempuan',
            'GAJI' => 'required|numeric|min:0',
        ]);

        try {
            DB::insert("
                INSERT INTO DOKTER (NAMA_DOKTER, SPESIALISASI, NOMOR_SIP, JADWAL_PRAKTEK, JENIS_KELAMIN, GAJI)
                VALUES (:nama, :spesialisasi, :nomor_sip, :jadwal, :jenis_kelamin, :gaji)
            ", [
                'nama' => $request->NAMA_DOKTER,
                'spesialisasi' => $request->SPESIALISASI,
                'nomor_sip' => $request->NOMOR_SIP,
                'jadwal' => $request->JADWAL_PRAKTEK,
                'jenis_kelamin' => $request->JENIS_KELAMIN,
                'gaji' => $request->GAJI,
            ]);

            return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data dokter.');
        }
    }

    public function edit($id)
    {
        $dokter = DB::table('DOKTER')->where('ID_DOKTER', $id)->first();

        if (!$dokter) {
            return redirect()->route('dokter.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('DOKTER.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'nomor_sip' => 'required|string|max:50',
            'jadwal_praktek' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'gaji' => 'required|numeric|min:0',
        ]);

        try {
            DB::table('DOKTER')->where('ID_DOKTER', $id)->update([
                'NAMA_DOKTER' => $request->nama_dokter,
                'SPESIALISASI' => $request->spesialisasi,
                'NOMOR_SIP' => $request->nomor_sip,
                'JADWAL_PRAKTEK' => $request->jadwal_praktek,
                'JENIS_KELAMIN' => $request->jenis_kelamin,
                'GAJI' => $request->gaji,
            ]);

            return redirect()->route('dokter.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data dokter.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('DOKTER')->where('ID_DOKTER', $id)->delete();
            return redirect()->route('dokter.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data dokter.');
        }
    }
}