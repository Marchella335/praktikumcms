<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class REKAM_MEDIS extends Model
{
    use HasFactory;

    protected $connection = 'oracle';
    protected $table = 'REKAM_MEDIS';
    protected $primaryKey = 'ID_REKAM_MEDIS';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ID_REKAM_MEDIS',
        'ID_PASIEN',
        'ID_STAF',
        'ID_DOKTER',
        'TANGGAL',
        'HASIL_PEMERIKSAAN',
        'RIWAYAT_REKAM_MEDIS',
        'DIAGNOSA',
        'TINDAKAN',
        'OBAT'
    ];

    protected $casts = [
        'TANGGAL' => 'date'
    ];

    public function pasien()
    {
        return $this->belongsTo(PASIEN::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function dokter()
    {
        return $this->belongsTo(DOKTER::class, 'ID_DOKTER', 'ID_DOKTER');
    }

    public function staf()
    {
        return $this->belongsTo(STAF::class, 'ID_STAF', 'ID_STAF');
    }
}
