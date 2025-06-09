<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STAF extends Model
{
    use HasFactory;
    
    protected $table = 'STAF';
    protected $primaryKey = 'ID_STAF';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'NAMA_STAF', 
        'DEPARTEMEN', 
        'NOMOR_TELEPON', 
        'GAJI'
    ];

    // Cast attributes untuk memastikan tipe data yang benar
    protected $casts = [
        'ID_STAF' => 'integer',
        'NAMA_STAF' => 'string',
        'DEPARTEMEN' => 'string',
        'NOMOR_TELEPON' => 'string',
        'GAJI' => 'decimal:2'
    ];

    // Accessor untuk memastikan data tidak null
    public function getNamaStafAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getDepartemenAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getNomorTeleponAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getGajiAttribute($value)
    {
        return $value ?? 0;
    }

    // Mutator untuk sanitasi input
    public function setNamaStafAttribute($value)
    {
        $this->attributes['NAMA_STAF'] = trim($value);
    }

    public function setDepartemenAttribute($value)
    {
        $this->attributes['DEPARTEMEN'] = trim($value);
    }

    public function setNomorTeleponAttribute($value)
    {
        $this->attributes['NOMOR_TELEPON'] = trim($value);
    }

    public function setGajiAttribute($value)
    {
        $this->attributes['GAJI'] = floatval($value);
    }
}