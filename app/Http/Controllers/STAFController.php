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

    // Method show menggunakan findOrFail
    public function show($id)
    {
        try {
            // Menggunakan Model STAF dengan findOrFail
            $staf = STAF::findOrFail($id);
            return view('STAF.show', compact('staf'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika data tidak ditemukan, Laravel otomatis throw 404
            // Tapi kita bisa custom pesan errornya
            return redirect()->route('staf.index')->with('error', 'Data staf dengan ID ' . $id . ' tidak ditemukan.');
        }
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

    // Method edit menggunakan findOrFail 
    public function edit($id)
    {
        try {
            $staf = STAF::findOrFail($id);
            return view('STAF.edit', compact('staf'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('staf.index')->with('error', 'Data staf tidak ditemukan untuk diedit.');
        }
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
            // Cek dulu apakah data exists menggunakan findOrFail
            $staf = STAF::findOrFail($id);

            // HAPUS CREATED_AT dan UPDATED_AT dari UPDATE
            DB::table('STAF')->where('ID_STAF', $id)->update([
                'NAMA_STAF' => $request->nama_staf,
                'DEPARTEMEN' => $request->departemen,
                'NOMOR_TELEPON' => $request->nomor_telepon,
                'GAJI' => $request->gaji,
            ]);

            return redirect()->route('staf.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('staf.index')->with('error', 'Data staf tidak ditemukan untuk diupdate.');
        } catch (\Exception $e) {
            Log::error('Error updating staf: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data staf.');
        }
    }

    public function destroy($id)
    {
        try {
            // Menggunakan findOrFail untuk memastikan data ada sebelum dihapus
            $staf = STAF::findOrFail($id);
            
            DB::table('STAF')->where('ID_STAF', $id)->delete();
            return redirect()->route('staf.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('staf.index')->with('error', 'Data staf tidak ditemukan untuk dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting staf: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data staf.');
        }
    }

    // Method tambahan untuk demonstrasi firstOrFail
    public function findByName($name)
    {
        try {
            // Menggunakan firstOrFail untuk mencari berdasarkan nama
            $staf = STAF::where('NAMA_STAF', $name)->firstOrFail();
            return view('STAF.show', compact('staf'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('staf.index')->with('error', 'Staf dengan nama "' . $name . '" tidak ditemukan.');
        }
    }

    // Method tambahan untuk demonstrasi try-catch manual
    public function findByNameAlternative($name)
    {
        try {
            $staf = DB::table('STAF')->where('NAMA_STAF', $name)->first();
            
            if (!$staf) {
                throw new \Exception('Staf dengan nama tersebut tidak ditemukan');
            }

            return view('STAF.show', compact('staf'));
        } catch (\Exception $e) {
            Log::error('Error finding staf by name: ' . $e->getMessage());
            return redirect()->route('staf.index')->with('error', 'Staf dengan nama "' . $name . '" tidak ditemukan.');
        }
    }
}