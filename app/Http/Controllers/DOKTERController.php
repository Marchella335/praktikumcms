<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\DOKTER;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DOKTERController extends Controller
{
    public function index()
    {
        try {
            $dokter = DB::table('DOKTER')->orderBy('ID_DOKTER', 'asc')->get();
            return view('DOKTER.index', compact('dokter'));
        } catch (\Exception $e) {
            Log::error('Error fetching dokter list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data dokter.');
        }
    }

    // Method menggunakan findOrFail 
    public function show($id)
    {
        try {
            // Menggunakan Model Eloquent dengan findOrFail
            $dokter = DOKTER::findOrFail($id);
            return view('DOKTER.show', compact('dokter'));
        } catch (ModelNotFoundException $e) {
            //  otomatis  404 error jika data tidak ditemukan
            Log::error('Dokter not found with ID: ' . $id);
            return redirect()->route('dokter.index')
                ->with('error', 'Data dokter dengan ID ' . $id . ' tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error showing dokter: ' . $e->getMessage());
            return redirect()->route('dokter.index')
                ->with('error', 'Terjadi kesalahan saat menampilkan data dokter.');
        }
    }

    public function create()
    {
        try {
            return view('DOKTER.create');
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('dokter.index')
                ->with('error', 'Terjadi kesalahan saat memuat form tambah dokter.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'NAMA_DOKTER' => 'required|string|max:255',
                'SPESIALISASI' => 'required|string|max:255',
                'NOMOR_SIP' => 'required|string|max:50|unique:DOKTER,NOMOR_SIP',
                'JADWAL_PRAKTEK' => 'required|string|max:255',
                'JENIS_KELAMIN' => 'required|in:Laki-laki,Perempuan',
                'GAJI' => 'required|numeric|min:0',
            ]);

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

            return redirect()->route('dokter.index')
                ->with('success', 'Data dokter berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->validator)->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors (duplicate entry, etc.)
            Log::error('Database error creating dokter: ' . $e->getMessage());
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Nomor SIP sudah terdaftar. Gunakan nomor SIP yang berbeda.')
                    ->withInput();
            }
            return back()->with('error', 'Terjadi kesalahan database saat menyimpan data dokter.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data dokter.')
                ->withInput();
        }
    }

    // Method menggunakan findOrFail untuk edit
    public function edit($id)
    {
        try {
            // Menggunakan Model Eloquent dengan findOrFail
            $dokter = DOKTER::findOrFail($id);
            return view('DOKTER.edit', compact('dokter'));
        } catch (ModelNotFoundException $e) {
            Log::error('Dokter not found for edit with ID: ' . $id);
            return redirect()->route('dokter.index')
                ->with('error', 'Data dokter dengan ID ' . $id . ' tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->route('dokter.index')
                ->with('error', 'Terjadi kesalahan saat memuat form edit dokter.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Cek apakah data dokter ada terlebih dahulu
            $dokter = DOKTER::findOrFail($id);

            $request->validate([
                'nama_dokter' => 'required|string|max:255',
                'spesialisasi' => 'required|string|max:255',
                'nomor_sip' => 'required|string|max:50|unique:DOKTER,NOMOR_SIP,' . $id . ',ID_DOKTER',
                'jadwal_praktek' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'gaji' => 'required|numeric|min:0',
            ]);

            DB::table('DOKTER')->where('ID_DOKTER', $id)->update([
                'NAMA_DOKTER' => $request->nama_dokter,
                'SPESIALISASI' => $request->spesialisasi,
                'NOMOR_SIP' => $request->nomor_sip,
                'JADWAL_PRAKTEK' => $request->jadwal_praktek,
                'JENIS_KELAMIN' => $request->jenis_kelamin,
                'GAJI' => $request->gaji
            ]);

            return redirect()->route('dokter.index')
                ->with('success', 'Data dokter berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            Log::error('Dokter not found for update with ID: ' . $id);
            return redirect()->route('dokter.index')
                ->with('error', 'Data dokter dengan ID ' . $id . ' tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error updating dokter: ' . $e->getMessage());
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Nomor SIP sudah terdaftar. Gunakan nomor SIP yang berbeda.')
                    ->withInput();
            }
            return back()->with('error', 'Terjadi kesalahan database saat memperbarui data dokter.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data dokter.')
                ->withInput();
        }
    }

    // Method menggunakan findOrFail untuk destroy
    public function destroy($id)
    {
        try {
            // Cek apakah data dokter ada terlebih dahulu
            $dokter = DOKTER::findOrFail($id);
            
            // Simpan nama dokter untuk pesan konfirmasi
            $namaDokter = $dokter->NAMA_DOKTER;
            
            DB::table('DOKTER')->where('ID_DOKTER', $id)->delete();
            
            return redirect()->route('dokter.index')
                ->with('success', 'Data dokter ' . $namaDokter . ' berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::error('Dokter not found for delete with ID: ' . $id);
            return redirect()->route('dokter.index')
                ->with('error', 'Data dokter dengan ID ' . $id . ' tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error deleting dokter: ' . $e->getMessage());
            // Cek jika ada foreign key constraint
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Data dokter tidak dapat dihapus karena masih terkait dengan data lain.');
            }
            return back()->with('error', 'Terjadi kesalahan database saat menghapus data dokter.');
        } catch (\Exception $e) {
            Log::error('Error deleting dokter: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data dokter.');
        }
    }

    // Method tambahan untuk demo error handling dengan firstOrFail
    public function findByEmail($email)
    {
        try {
            // Contoh penggunaan firstOrFail sesuai dokumen
            $dokter = DOKTER::where('email', $email)->firstOrFail();
            return response()->json([
                'success' => true,
                'data' => $dokter
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Dokter not found with email: ' . $email);
            return response()->json([
                'success' => false,
                'message' => 'Dokter dengan email ' . $email . ' tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error finding dokter by email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari data dokter.'
            ], 500);
        }
    }

    // Method tambahan untuk demo error handling dengan try-catch biasa
    public function findBySpecialization($spesialisasi)
    {
        try {
            $dokter = DB::table('DOKTER')
                ->where('SPESIALISASI', 'LIKE', '%' . $spesialisasi . '%')
                ->get();

            if ($dokter->isEmpty()) {
                throw new \Exception('Tidak ada dokter dengan spesialisasi: ' . $spesialisasi);
            }

            return response()->json([
                'success' => true,
                'data' => $dokter,
                'count' => $dokter->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error finding dokter by specialization: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}