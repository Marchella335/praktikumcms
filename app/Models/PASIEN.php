<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PASIEN extends Model
{
    use HasFactory;
    
    protected $table = 'PASIEN';
    protected $primaryKey = 'ID_PASIEN';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'NAMA_PASIEN',
        'ALAMAT',
        'NOMOR_TELEPON',
        'USIA',
        'JENIS_KELAMIN',
        'STATUS_PASIEN'
    ];

    // Cast attributes untuk memastikan tipe data yang benar
    protected $casts = [
        'ID_PASIEN' => 'integer',
        'NAMA_PASIEN' => 'string',
        'ALAMAT' => 'string',
        'NOMOR_TELEPON' => 'string',
        'USIA' => 'integer',
        'JENIS_KELAMIN' => 'string',
        'STATUS_PASIEN' => 'string'
    ];

    // Accessor untuk memastikan data tidak null
    public function getNamaPasienAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getAlamatAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getNomorTeleponAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getUsiaAttribute($value)
    {
        return $value ?? 0;
    }

    public function getJenisKelaminAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getStatusPasienAttribute($value)
    {
        return $value ?? 'N/A';
    }

    // Mutator untuk sanitasi input
    public function setNamaPasienAttribute($value)
    {
        $this->attributes['NAMA_PASIEN'] = trim($value);
    }

    public function setAlamatAttribute($value)
    {
        $this->attributes['ALAMAT'] = trim($value);
    }

    public function setNomorTeleponAttribute($value)
    {
        $this->attributes['NOMOR_TELEPON'] = trim($value);
    }

    public function setUsiaAttribute($value)
    {
        $this->attributes['USIA'] = intval($value);
    }

    public function setJenisKelaminAttribute($value)
    {
        $this->attributes['JENIS_KELAMIN'] = trim($value);
    }

    public function setStatusPasienAttribute($value)
    {
        $this->attributes['STATUS_PASIEN'] = trim($value);
    }

    // Relasi jika diperlukan
    public function janjiTemu()
    {
        return $this->hasMany(JANJI_TEMU::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function rekamMedis()
    {
        return $this->hasMany(REKAM_MEDIS::class, 'ID_PASIEN', 'ID_PASIEN');
    }
}