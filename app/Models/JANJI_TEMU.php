<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien;
use App\Models\Dokter;

class JANJI_TEMU extends Model
{
    use HasFactory;
    
    protected $table = 'JANJI_TEMU';
    protected $primaryKey = 'ID_JANJI';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'ID_PASIEN',
        'ID_DOKTER',
        'TANGGAL_JANJI',
        'JAM_JANJI',
        'KELUHAN'
    ];

    // Cast attributes untuk memastikan tipe data yang benar
    protected $casts = [
        'ID_JANJI' => 'integer',
        'ID_PASIEN' => 'integer',
        'ID_DOKTER' => 'integer',
        'TANGGAL_JANJI' => 'date',
        'JAM_JANJI' => 'string',
        'KELUHAN' => 'string'
    ];

    // Accessor untuk memastikan data tidak null
    public function getIdPasienAttribute($value)
    {
        return $value ?? 0;
    }

    public function getIdDokterAttribute($value)
    {
        return $value ?? 0;
    }

    public function getTanggalJanjiAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getJamJanjiAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getKeluhanAttribute($value)
    {
        return $value ?? 'N/A';
    }

    // Mutator untuk sanitasi input
    public function setIdPasienAttribute($value)
    {
        $this->attributes['ID_PASIEN'] = intval($value);
    }

    public function setIdDokterAttribute($value)
    {
        $this->attributes['ID_DOKTER'] = intval($value);
    }

    public function setTanggalJanjiAttribute($value)
    {
        $this->attributes['TANGGAL_JANJI'] = trim($value);
    }

    public function setJamJanjiAttribute($value)
    {
        $this->attributes['JAM_JANJI'] = trim($value);
    }

    public function setKeluhanAttribute($value)
    {
        $this->attributes['KELUHAN'] = trim($value);
    }

    // Relasi ke pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'ID_PASIEN');
    }

    // Relasi ke dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'ID_DOKTER');
    }
}
