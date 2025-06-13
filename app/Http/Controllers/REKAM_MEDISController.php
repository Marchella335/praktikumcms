<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\REKAM_MEDIS;
use App\Models\PASIEN;
use App\Models\DOKTER;
use App\Models\STAF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class REKAM_MEDISController extends Controller
{
    public function index()
    {
        $rekamMedis = DB::table('REKAM_MEDIS')
            ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
            ->select(
                'REKAM_MEDIS.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER',
                'STAF.NAMA_STAF'
            )
            ->orderBy('REKAM_MEDIS.TANGGAL', 'desc')
            ->orderBy('REKAM_MEDIS.ID_REKAM_MEDIS', 'desc')
            ->get();
        
        return view('REKAM_MEDIS.index', compact('rekamMedis'));
    }

    public function show($id)
    {
        $rekamMedis = DB::table('REKAM_MEDIS')
            ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
            ->select(
                'REKAM_MEDIS.*',
                'PASIEN.NAMA_PASIEN',
                'PASIEN.NOMOR_TELEPON',
                'PASIEN.ALAMAT',
                'DOKTER.NAMA_DOKTER',
                'DOKTER.SPESIALISASI',
                'STAF.NAMA_STAF'
            )
            ->where('REKAM_MEDIS.ID_REKAM_MEDIS', $id)
            ->first();
        
        if (!$rekamMedis) {
            return redirect()->route('rekam_medis.index')->with('error', 'Data rekam medis tidak ditemukan.');
        }

        return view('REKAM_MEDIS.show', compact('rekamMedis'));
    }

    public function create()
    {
        $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();
        $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->orderBy('NAMA_DOKTER')->get();
        $staf = DB::table('STAF')->select('ID_STAF', 'NAMA_STAF')->orderBy('NAMA_STAF')->get();
        
        return view('REKAM_MEDIS.create', compact('pasien', 'dokter', 'staf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_PASIEN' => 'required|integer|exists:PASIEN,ID_PASIEN',
            'ID_DOKTER' => 'required|integer|exists:DOKTER,ID_DOKTER',
            'ID_STAF' => 'nullable|integer|exists:STAF,ID_STAF',
            'TANGGAL' => 'required|date|before_or_equal:today',
            'HASIL_PEMERIKSAAN' => 'required|string|max:2000',
            'RIWAYAT_REKAM_MEDIS' => 'nullable|string|max:2000',
            'DIAGNOSA' => 'required|string|max:1000',
            'TINDAKAN' => 'required|string|max:1000',
            'OBAT' => 'nullable|string|max:1000',
        ], [
            'ID_PASIEN.required' => 'Pasien harus dipilih.',
            'ID_PASIEN.exists' => 'Pasien yang dipilih tidak valid.',
            'ID_DOKTER.required' => 'Dokter harus dipilih.',
            'ID_DOKTER.exists' => 'Dokter yang dipilih tidak valid.',
            'ID_STAF.exists' => 'Staf yang dipilih tidak valid.',
            'TANGGAL.required' => 'Tanggal pemeriksaan harus diisi.',
            'TANGGAL.before_or_equal' => 'Tanggal pemeriksaan tidak boleh lebih dari hari ini.',
            'HASIL_PEMERIKSAAN.required' => 'Hasil pemeriksaan harus diisi.',
            'HASIL_PEMERIKSAAN.max' => 'Hasil pemeriksaan maksimal 2000 karakter.',
            'RIWAYAT_REKAM_MEDIS.max' => 'Riwayat rekam medis maksimal 2000 karakter.',
            'DIAGNOSA.required' => 'Diagnosa harus diisi.',
            'DIAGNOSA.max' => 'Diagnosa maksimal 1000 karakter.',
            'TINDAKAN.required' => 'Tindakan harus diisi.',
            'TINDAKAN.max' => 'Tindakan maksimal 1000 karakter.',
            'OBAT.max' => 'Obat maksimal 1000 karakter.',
        ]);

        try {
            DB::insert("
                INSERT INTO REKAM_MEDIS (ID_PASIEN, ID_DOKTER, ID_STAF, TANGGAL, HASIL_PEMERIKSAAN, RIWAYAT_REKAM_MEDIS, DIAGNOSA, TINDAKAN, OBAT)
                VALUES (:id_pasien, :id_dokter, :id_staf, :tanggal, :hasil_pemeriksaan, :riwayat_rekam_medis, :diagnosa, :tindakan, :obat)
            ", [
                'id_pasien' => $request->ID_PASIEN,
                'id_dokter' => $request->ID_DOKTER,
                'id_staf' => $request->ID_STAF,
                'tanggal' => $request->TANGGAL,
                'hasil_pemeriksaan' => trim($request->HASIL_PEMERIKSAAN),
                'riwayat_rekam_medis' => trim($request->RIWAYAT_REKAM_MEDIS),
                'diagnosa' => trim($request->DIAGNOSA),
                'tindakan' => trim($request->TINDAKAN),
                'obat' => trim($request->OBAT),
            ]);

            Log::info('Rekam medis created successfully', [
                'id_pasien' => $request->ID_PASIEN,
                'id_dokter' => $request->ID_DOKTER,
                'tanggal' => $request->TANGGAL,
            ]);

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error creating rekam medis: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat rekam medis. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $rekamMedis = DB::table('REKAM_MEDIS')->where('ID_REKAM_MEDIS', $id)->first();
        
        if (!$rekamMedis) {
            return redirect()->route('rekam_medis.index')->with('error', 'Data rekam medis tidak ditemukan.');
        }

        $pasien = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();
        $dokter = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER', 'SPESIALISASI')->orderBy('NAMA_DOKTER')->get();
        $staf = DB::table('STAF')->select('ID_STAF', 'NAMA_STAF')->orderBy('NAMA_STAF')->get();

        return view('REKAM_MEDIS.edit', compact('rekamMedis', 'pasien', 'dokter', 'staf'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasien' => 'required|integer|exists:PASIEN,ID_PASIEN',
            'id_dokter' => 'required|integer|exists:DOKTER,ID_DOKTER',
            'id_staf' => 'nullable|integer|exists:STAF,ID_STAF',
            'tanggal' => 'required|date|before_or_equal:today',
            'hasil_pemeriksaan' => 'required|string|max:2000',
            'riwayat_rekam_medis' => 'nullable|string|max:2000',
            'diagnosa' => 'required|string|max:1000',
            'tindakan' => 'required|string|max:1000',
            'obat' => 'nullable|string|max:1000',
        ], [
            'id_pasien.required' => 'Pasien harus dipilih.',
            'id_pasien.exists' => 'Pasien yang dipilih tidak valid.',
            'id_dokter.required' => 'Dokter harus dipilih.',
            'id_dokter.exists' => 'Dokter yang dipilih tidak valid.',
            'id_staf.exists' => 'Staf yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal pemeriksaan harus diisi.',
            'tanggal.before_or_equal' => 'Tanggal pemeriksaan tidak boleh lebih dari hari ini.',
            'hasil_pemeriksaan.required' => 'Hasil pemeriksaan harus diisi.',
            'hasil_pemeriksaan.max' => 'Hasil pemeriksaan maksimal 2000 karakter.',
            'riwayat_rekam_medis.max' => 'Riwayat rekam medis maksimal 2000 karakter.',
            'diagnosa.required' => 'Diagnosa harus diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
            'tindakan.required' => 'Tindakan harus diisi.',
            'tindakan.max' => 'Tindakan maksimal 1000 karakter.',
            'obat.max' => 'Obat maksimal 1000 karakter.',
        ]);

        try {
            // Get old data for logging
            $oldData = DB::table('REKAM_MEDIS')->where('ID_REKAM_MEDIS', $id)->first();
            
            if (!$oldData) {
                return redirect()->route('rekam_medis.index')->with('error', 'Data rekam medis tidak ditemukan.');
            }
            
            // Update data
            $updated = DB::table('REKAM_MEDIS')->where('ID_REKAM_MEDIS', $id)->update([
                'ID_PASIEN' => $request->id_pasien,
                'ID_DOKTER' => $request->id_dokter,
                'ID_STAF' => $request->id_staf,
                'TANGGAL' => $request->tanggal,
                'HASIL_PEMERIKSAAN' => trim($request->hasil_pemeriksaan),
                'RIWAYAT_REKAM_MEDIS' => trim($request->riwayat_rekam_medis),
                'DIAGNOSA' => trim($request->diagnosa),
                'TINDAKAN' => trim($request->tindakan),
                'OBAT' => trim($request->obat),
            ]);

            if ($updated) {
                // Log the update
                Log::info('Rekam medis updated successfully', [
                    'id' => $id,
                    'old_data' => $oldData,
                    'new_data' => [
                        'ID_PASIEN' => $request->id_pasien,
                        'ID_DOKTER' => $request->id_dokter,
                        'ID_STAF' => $request->id_staf,
                        'TANGGAL' => $request->tanggal,
                        'DIAGNOSA' => $request->diagnosa,
                    ]
                ]);

                return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
            } else {
                return back()->withInput()->with('error', 'Tidak ada perubahan data yang disimpan.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating rekam medis: ' . $e->getMessage(), [
                'id' => $id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui rekam medis. Silakan coba lagi.');
        }
    }
    
    public function destroy($id)
    {
        try {
            $rekamMedis = DB::table('REKAM_MEDIS')->where('ID_REKAM_MEDIS', $id)->first();
            
            if (!$rekamMedis) {
                return redirect()->route('rekam_medis.index')->with('error', 'Data rekam medis tidak ditemukan.');
            }

            DB::table('REKAM_MEDIS')->where('ID_REKAM_MEDIS', $id)->delete();
            
            Log::info('Rekam medis deleted successfully', [
                'id' => $id,
                'deleted_data' => $rekamMedis
            ]);

            return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting rekam medis: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus rekam medis.');
        }
    }

    // Method tambahan untuk menampilkan rekam medis berdasarkan pasien
    public function byPasien($idPasien)
    {
        $rekamMedis = DB::table('REKAM_MEDIS')
            ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
            ->select(
                'REKAM_MEDIS.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER',
                'STAF.NAMA_STAF'
            )
            ->where('REKAM_MEDIS.ID_PASIEN', $idPasien)
            ->orderBy('REKAM_MEDIS.TANGGAL', 'desc')
            ->orderBy('REKAM_MEDIS.ID_REKAM_MEDIS', 'desc')
            ->get();

        $pasien = DB::table('PASIEN')->where('ID_PASIEN', $idPasien)->first();

        if (!$pasien) {
            return redirect()->route('rekam_medis.index')->with('error', 'Data pasien tidak ditemukan.');
        }

        return view('REKAM_MEDIS.by_pasien', compact('rekamMedis', 'pasien'));
    }

    // Method tambahan untuk menampilkan rekam medis berdasarkan dokter
    public function byDokter($idDokter)
    {
        $rekamMedis = DB::table('REKAM_MEDIS')
            ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
            ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
            ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
            ->select(
                'REKAM_MEDIS.*',
                'PASIEN.NAMA_PASIEN',
                'DOKTER.NAMA_DOKTER',
                'STAF.NAMA_STAF'
            )
            ->where('REKAM_MEDIS.ID_DOKTER', $idDokter)
            ->orderBy('REKAM_MEDIS.TANGGAL', 'desc')
            ->orderBy('REKAM_MEDIS.ID_REKAM_MEDIS', 'desc')
            ->get();

        $dokter = DB::table('DOKTER')->where('ID_DOKTER', $idDokter)->first();

        if (!$dokter) {
            return redirect()->route('rekam_medis.index')->with('error', 'Data dokter tidak ditemukan.');
        }

        return view('REKAM_MEDIS.by_dokter', compact('rekamMedis', 'dokter'));
    }

    // Method untuk statistik rekam medis
    public function statistik()
    {
        try {
            $totalRekamMedis = DB::table('REKAM_MEDIS')->count();
            $rekamMedisHariIni = DB::table('REKAM_MEDIS')
                ->whereDate('TANGGAL', Carbon::today())
                ->count();
            $rekamMedisBulanIni = DB::table('REKAM_MEDIS')
                ->whereMonth('TANGGAL', Carbon::now()->month)
                ->whereYear('TANGGAL', Carbon::now()->year)
                ->count();

            // Rekam medis per dokter bulan ini
            $rekamMedisPerDokter = DB::table('REKAM_MEDIS')
                ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->select('DOKTER.NAMA_DOKTER', DB::raw('COUNT(*) as total'))
                ->whereMonth('REKAM_MEDIS.TANGGAL', Carbon::now()->month)
                ->whereYear('REKAM_MEDIS.TANGGAL', Carbon::now()->year)
                ->groupBy('DOKTER.ID_DOKTER', 'DOKTER.NAMA_DOKTER')
                ->orderBy('total', 'desc')
                ->get();

            // Rekam medis terbaru
            $rekamMedisTerbaru = DB::table('REKAM_MEDIS')
                ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->select(
                    'REKAM_MEDIS.ID_REKAM_MEDIS',
                    'REKAM_MEDIS.TANGGAL',
                    'PASIEN.NAMA_PASIEN',
                    'DOKTER.NAMA_DOKTER',
                    'REKAM_MEDIS.DIAGNOSA'
                )
                ->orderBy('REKAM_MEDIS.TANGGAL', 'desc')
                ->orderBy('REKAM_MEDIS.ID_REKAM_MEDIS', 'desc')
                ->limit(10)
                ->get();

            return view('REKAM_MEDIS.statistik', compact(
                'totalRekamMedis',
                'rekamMedisHariIni',
                'rekamMedisBulanIni',
                'rekamMedisPerDokter',
                'rekamMedisTerbaru'
            ));
        } catch (\Exception $e) {
            Log::error('Error getting rekam medis statistics: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data statistik.');
        }
    }

    // Method untuk pencarian rekam medis
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'dokter_id' => 'nullable|integer|exists:DOKTER,ID_DOKTER',
            'pasien_id' => 'nullable|integer|exists:PASIEN,ID_PASIEN',
        ]);

        try {
            $query = DB::table('REKAM_MEDIS')
                ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
                ->select(
                    'REKAM_MEDIS.*',
                    'PASIEN.NAMA_PASIEN',
                    'DOKTER.NAMA_DOKTER',
                    'STAF.NAMA_STAF'
                );

            // Filter berdasarkan keyword
            if ($request->filled('keyword')) {
                $keyword = '%' . $request->keyword . '%';
                $query->where(function ($q) use ($keyword) {
                    $q->where('PASIEN.NAMA_PASIEN', 'like', $keyword)
                      ->orWhere('DOKTER.NAMA_DOKTER', 'like', $keyword)
                      ->orWhere('REKAM_MEDIS.DIAGNOSA', 'like', $keyword)
                      ->orWhere('REKAM_MEDIS.HASIL_PEMERIKSAAN', 'like', $keyword);
                });
            }

            // Filter berdasarkan tanggal
            if ($request->filled('start_date')) {
                $query->whereDate('REKAM_MEDIS.TANGGAL', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('REKAM_MEDIS.TANGGAL', '<=', $request->end_date);
            }

            // Filter berdasarkan dokter
            if ($request->filled('dokter_id')) {
                $query->where('REKAM_MEDIS.ID_DOKTER', $request->dokter_id);
            }

            // Filter berdasarkan pasien
            if ($request->filled('pasien_id')) {
                $query->where('REKAM_MEDIS.ID_PASIEN', $request->pasien_id);
            }

            $rekamMedis = $query->orderBy('REKAM_MEDIS.TANGGAL', 'desc')
                               ->orderBy('REKAM_MEDIS.ID_REKAM_MEDIS', 'desc')
                               ->get();

            // Data untuk dropdown filter
            $dokters = DB::table('DOKTER')->select('ID_DOKTER', 'NAMA_DOKTER')->orderBy('NAMA_DOKTER')->get();
            $pasiens = DB::table('PASIEN')->select('ID_PASIEN', 'NAMA_PASIEN')->orderBy('NAMA_PASIEN')->get();

            return view('REKAM_MEDIS.search', compact('rekamMedis', 'dokters', 'pasiens'));
        } catch (\Exception $e) {
            Log::error('Error searching rekam medis: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mencari data rekam medis.');
        }
    }

    // Method untuk export data (dapat dikembangkan untuk PDF/Excel)
    public function export(Request $request)
    {
        try {
            $query = DB::table('REKAM_MEDIS')
                ->join('PASIEN', 'REKAM_MEDIS.ID_PASIEN', '=', 'PASIEN.ID_PASIEN')
                ->join('DOKTER', 'REKAM_MEDIS.ID_DOKTER', '=', 'DOKTER.ID_DOKTER')
                ->leftJoin('STAF', 'REKAM_MEDIS.ID_STAF', '=', 'STAF.ID_STAF')
                ->select(
                    'REKAM_MEDIS.*',
                    'PASIEN.NAMA_PASIEN',
                    'DOKTER.NAMA_DOKTER',
                    'STAF.NAMA_STAF'
                );

            // Apply filters if provided
            if ($request->filled('start_date')) {
                $query->whereDate('REKAM_MEDIS.TANGGAL', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('REKAM_MEDIS.TANGGAL', '<=', $request->end_date);
            }

            if ($request->filled('dokter_id')) {
                $query->where('REKAM_MEDIS.ID_DOKTER', $request->dokter_id);
            }

            $rekamMedis = $query->orderBy('REKAM_MEDIS.TANGGAL', 'desc')->get();

            // Return view untuk print/export
            return view('REKAM_MEDIS.export', compact('rekamMedis'));
        } catch (\Exception $e) {
            Log::error('Error exporting rekam medis: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengexport data rekam medis.');
        }
    }
}