<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DOKTER extends Model
{
    protected $table = 'DOKTER';
    protected $primaryKey = 'ID_DOKTER';
    public $timestamps = true;
    
    // Jika menggunakan custom timestamp columns
    const CREATED_AT = 'CREATED_AT';
    const UPDATED_AT = 'UPDATED_AT';

    protected $fillable = [
        'NAMA_DOKTER',
        'SPESIALISASI', 
        'NOMOR_SIP',
        'JADWAL_PRAKTEK',
        'JENIS_KELAMIN',
        'GAJI'
    ];

    protected $casts = [
        'GAJI' => 'decimal:2',
        'CREATED_AT' => 'datetime',
        'UPDATED_AT' => 'datetime'
    ];

    // Scope untuk pencarian
    public function scopeBySpecialization($query, $spesialisasi)
    {
        return $query->where('SPESIALISASI', 'LIKE', '%' . $spesialisasi . '%');
    }

    public function scopeByGender($query, $jenisKelamin)
    {
        return $query->where('JENIS_KELAMIN', $jenisKelamin);
    }
}