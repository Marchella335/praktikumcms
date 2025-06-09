<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\STAF;
use Carbon\Carbon;

class STAFController extends Controller
{
    public function index()
    {
        $staf = DB::table('STAF')->orderBy('ID_STAF', 'asc')->get();
        return view('STAF.index', compact('staf'));
    }

    public function show($id)
    {
        $staf = DB::table('STAF')->where('ID_STAF', $id)->first();
        
        if (!$staf) {
            return redirect()->route('staf.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('STAF.show', compact('staf'));
    }

    public function create()
    {
        return view('STAF.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NAMA_STAF' => 'required|string|max:255',
            'DEPARTEMEN' => 'required|string|max:255',
            'NOMOR_TELEPON' => 'required|string|max:20',
            'GAJI' => 'required|numeric|min:0',
        ]);

        try {
            // HAPUS CREATED_AT dan UPDATED_AT dari INSERT
            DB::insert("
                INSERT INTO STAF (NAMA_STAF, DEPARTEMEN, NOMOR_TELEPON, GAJI)
                VALUES (:nama, :departemen, :telepon, :gaji)
            ", [
                'nama' => $request->NAMA_STAF,
                'departemen' => $request->DEPARTEMEN,
                'telepon' => $request->NOMOR_TELEPON,
                'gaji' => $request->GAJI,
            ]);

            return redirect()->route('staf.index')->with('success', 'Data staf berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating staf: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data staf.');
        }
    }

    public function edit($id)
    {
        $staf = DB::table('STAF')->where('ID_STAF', $id)->first();

        if (!$staf) {
            return redirect()->route('staf.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('STAF.edit', compact('staf'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_staf' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'gaji' => 'required|numeric|min:0',
        ]);

        try {
            // HAPUS CREATED_AT dan UPDATED_AT dari UPDATE
            DB::table('STAF')->where('ID_STAF', $id)->update([
                'NAMA_STAF' => $request->nama_staf,
                'DEPARTEMEN' => $request->departemen,
                'NOMOR_TELEPON' => $request->nomor_telepon,
                'GAJI' => $request->gaji,
            ]);

            return redirect()->route('staf.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating staf: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data staf.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('STAF')->where('ID_STAF', $id)->delete();
            return redirect()->route('staf.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting staf: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data staf.');
        }
    }
}