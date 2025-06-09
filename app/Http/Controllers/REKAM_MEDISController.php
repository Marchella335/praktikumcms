<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\REKAM_MEDIS;
use App\Models\PASIEN;
use App\Models\DOKTER;
use App\Models\STAF;

class REKAM_MEDISController extends Controller
{
    // use HasFactory;
 public function index()
    {
        $rekamMedis = REKAM_MEDIS::with(['pasien', 'dokter', 'staf'])->paginate(10);
        return view('rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        $pasiens = PASIEN::all();
        $dokters = DOKTER::all();
        $stafs = STAF::all();
        return view('rekam_medis.create', compact('pasiens', 'dokters', 'stafs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_REKAM_MEDIS' => 'required|unique:REKAM_MEDIS,ID_REKAM_MEDIS',
            'ID_PASIEN' => 'required|exists:PASIEN,ID_PASIEN',
            'ID_DOKTER' => 'required|exists:DOKTER,ID_DOKTER',
            'ID_STAF' => 'nullable|exists:STAF,ID_STAF',
            'TANGGAL' => 'required|date',
            'HASIL_PEMERIKSAAN' => 'required|string|max:255',
            'RIWAYAT_REKAM_MEDIS' => 'nullable|string|max:255',
            'DIAGNOSA' => 'required|string|max:255',
            'TINDAKAN' => 'nullable|string|max:255',
            'OBAT' => 'nullable|string|max:255'
        ]);

        REKAM_MEDIS::create($request->all());

        return redirect()->route('rekam_medis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rekamMedis = REKAM_MEDIS::with(['pasien', 'dokter', 'staf'])->findOrFail($id);
        return view('rekam_medis.show', compact('rekamMedis'));
    }

    public function edit($id)
    {
        $rekamMedis = REKAM_MEDISs::findOrFail($id);
        $pasiens = PASIEN::all();
        $dokters = DOKTER::all();
        $stafs = STAF::all();
        return view('rekam_medis.edit', compact('rekamMedis', 'pasiens', 'dokters', 'stafs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ID_PASIEN' => 'required|exists:PASIEN,ID_PASIEN',
            'ID_DOKTER' => 'required|exists:DOKTER,ID_DOKTER',
            'ID_STAF' => 'nullable|exists:STAF,ID_STAF',
            'TANGGAL' => 'required|date',
            'HASIL_PEMERIKSAAN' => 'required|string|max:255',
            'RIWAYAT_REKAM_MEDIS' => 'nullable|string|max:255',
            'DIAGNOSA' => 'required|string|max:255',
            'TINDAKAN' => 'nullable|string|max:255',
            'OBAT' => 'nullable|string|max:255'
        ]);

        $rekamMedis = REKAM_MEDIS::findOrFail($id);
        $rekamMedis->update($request->all());

        return redirect()->route('rekam_medis.index')
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekamMedis = REKAM_MEDIS::findOrFail($id);
        $rekamMedis->delete();

        return redirect()->route('rekam_medis.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
