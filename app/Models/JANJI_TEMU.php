<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Accessor untuk memastikan data tidak null dan format yang benar
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
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getJamJanjiAttribute($value)
    {
        return $value ?? '00:00';
    }

    public function getKeluhanAttribute($value)
    {
        return $value ?? 'N/A';
    }

    // Accessor tambahan untuk format tampilan
    public function getTanggalJanjiFormatAttribute()
    {
        return $this->TANGGAL_JANJI ? 
            Carbon::parse($this->TANGGAL_JANJI)->format('d/m/Y') : 'N/A';
    }

    public function getJamJanjiFormatAttribute()
    {
        return $this->JAM_JANJI ? 
            Carbon::parse($this->JAM_JANJI)->format('H:i') : 'N/A';
    }

    public function getWaktuLengkapAttribute()
    {
        if ($this->TANGGAL_JANJI && $this->JAM_JANJI) {
            return Carbon::parse($this->TANGGAL_JANJI . ' ' . $this->JAM_JANJI)->format('d/m/Y H:i');
        }
        return 'N/A';
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
        $this->attributes['TANGGAL_JANJI'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setJamJanjiAttribute($value)
    {
        $this->attributes['JAM_JANJI'] = $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function setKeluhanAttribute($value)
    {
        $this->attributes['KELUHAN'] = trim($value);
    }

    // Relasi dengan tabel lain
    public function pasien()
    {
        return $this->belongsTo(PASIEN::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function dokter()
    {
        return $this->belongsTo(DOKTER::class, 'ID_DOKTER', 'ID_DOKTER');
    }

    // Scope untuk query yang sering digunakan
    public function scopeToday($query)
    {
        return $query->whereDate('TANGGAL_JANJI', Carbon::today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('TANGGAL_JANJI', '>=', Carbon::today());
    }

    public function scopePast($query)
    {
        return $query->where('TANGGAL_JANJI', '<', Carbon::today());
    }

    public function scopeByPasien($query, $idPasien)
    {
        return $query->where('ID_PASIEN', $idPasien);
    }

    public function scopeByDokter($query, $idDokter)
    {
        return $query->where('ID_DOKTER', $idDokter);
    }

    public function scopeByDate($query, $tanggal)
    {
        return $query->whereDate('TANGGAL_JANJI', $tanggal);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('TANGGAL_JANJI', [$startDate, $endDate]);
    }

    // Method helper
    public function isToday()
    {
        return $this->TANGGAL_JANJI && Carbon::parse($this->TANGGAL_JANJI)->isToday();
    }

    public function isUpcoming()
    {
        return $this->TANGGAL_JANJI && Carbon::parse($this->TANGGAL_JANJI)->isFuture();
    }

    public function isPast()
    {
        return $this->TANGGAL_JANJI && Carbon::parse($this->TANGGAL_JANJI)->isPast();
    }

    public function getStatusAttribute()
    {
        if ($this->isToday()) {
            return 'Hari Ini';
        } elseif ($this->isUpcoming()) {
            return 'Akan Datang';
        } elseif ($this->isPast()) {
            return 'Selesai';
        }
        return 'Tidak Diketahui';
    }

    public function getDaysUntilAppointmentAttribute()
    {
        if ($this->TANGGAL_JANJI) {
            return Carbon::today()->diffInDays(Carbon::parse($this->TANGGAL_JANJI), false);
        }
        return null;
    }

    // Method untuk validasi bisnis
    public static function isDoctorAvailable($idDokter, $tanggalJanji, $jamJanji, $excludeId = null)
    {
        $query = self::where('ID_DOKTER', $idDokter)
                    ->where('TANGGAL_JANJI', $tanggalJanji)
                    ->where('JAM_JANJI', $jamJanji);
        
        if ($excludeId) {
            $query->where('ID_JANJI', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    public static function getAppointmentsByDoctor($idDokter, $tanggal = null)
    {
        $query = self::where('ID_DOKTER', $idDokter);
        
        if ($tanggal) {
            $query->whereDate('TANGGAL_JANJI', $tanggal);
        }
        
        return $query->orderBy('JAM_JANJI')->get();
    }

    public static function getAppointmentsByPatient($idPasien)
    {
        return self::where('ID_PASIEN', $idPasien)
                  ->orderBy('TANGGAL_JANJI', 'desc')
                  ->orderBy('JAM_JANJI', 'desc')
                  ->get();
    }
}