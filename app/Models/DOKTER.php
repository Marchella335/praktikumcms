<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOKTER extends Model
{
    use HasFactory;
    
    protected $table = 'DOKTER';
    protected $primaryKey = 'ID_DOKTER';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'NAMA_DOKTER',
        'SPESIALISASI',
        'NOMOR_SIP',
        'JADWAL_PRAKTEK',
        'JENIS_KELAMIN',
        'GAJI'
    ];

    // Cast attributes untuk memastikan tipe data yang benar
    protected $casts = [
        'ID_DOKTER' => 'integer',
        'NAMA_DOKTER' => 'string',
        'SPESIALISASI' => 'string',
        'NOMOR_SIP' => 'string',
        'JADWAL_PRAKTEK' => 'string',
        'JENIS_KELAMIN' => 'string',
        'GAJI' => 'decimal:2'
    ];

    // Accessor untuk memastikan data tidak null
    public function getNamaDokterAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getSpesialisasiAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getNomorSipAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getJadwalPraktekAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getJenisKelaminAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getGajiAttribute($value)
    {
        return $value ?? 0;
    }

    // Mutator untuk sanitasi input
    public function setNamaDokterAttribute($value)
    {
        $this->attributes['NAMA_DOKTER'] = trim($value);
    }

    public function setSpesialisasiAttribute($value)
    {
        $this->attributes['SPESIALISASI'] = trim($value);
    }

    public function setNomorSipAttribute($value)
    {
        $this->attributes['NOMOR_SIP'] = trim($value);
    }

    public function setJadwalPraktekAttribute($value)
    {
        $this->attributes['JADWAL_PRAKTEK'] = trim($value);
    }

    public function setJenisKelaminAttribute($value)
    {
        $this->attributes['JENIS_KELAMIN'] = trim($value);
    }

    public function setGajiAttribute($value)
    {
        $this->attributes['GAJI'] = floatval($value);
    }

    // Scope untuk query berdasarkan spesialisasi
    public function scopeBySpesialisasi($query, $spesialisasi)
    {
        return $query->where('SPESIALISASI', $spesialisasi);
    }

    // Scope untuk query berdasarkan jenis kelamin
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('JENIS_KELAMIN', $jenisKelamin);
    }

    // Scope untuk query berdasarkan range gaji
    public function scopeByGajiRange($query, $minGaji, $maxGaji = null)
    {
        $query->where('GAJI', '>=', $minGaji);
        if ($maxGaji) {
            $query->where('GAJI', '<=', $maxGaji);
        }
        return $query;
    }

    // Method untuk mendapatkan format gaji yang sudah diformat
    public function getFormattedGajiAttribute()
    {
        return 'Rp ' . number_format($this->GAJI, 0, ',', '.');
    }

    // Method untuk mendapatkan inisial nama dokter
    public function getInisialNamaAttribute()
    {
        $namaParts = explode(' ', $this->NAMA_DOKTER);
        $inisial = '';
        foreach ($namaParts as $part) {
            $inisial .= strtoupper(substr($part, 0, 1));
        }
        return $inisial;
    }
}