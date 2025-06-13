<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class REKAM_MEDIS extends Model
{
    use HasFactory;
    
    protected $table = 'REKAM_MEDIS';
    protected $primaryKey = 'ID_REKAM_MEDIS';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
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

    // Cast attributes untuk memastikan tipe data yang benar
    protected $casts = [
        'ID_REKAM_MEDIS' => 'integer',
        'ID_PASIEN' => 'integer',
        'ID_STAF' => 'integer',
        'ID_DOKTER' => 'integer',
        'TANGGAL' => 'date',
        'HASIL_PEMERIKSAAN' => 'string',
        'RIWAYAT_REKAM_MEDIS' => 'string',
        'DIAGNOSA' => 'string',
        'TINDAKAN' => 'string',
        'OBAT' => 'string'
    ];

    // Accessor untuk memastikan data tidak null dan format yang benar
    public function getIdPasienAttribute($value)
    {
        return $value ?? 0;
    }

    public function getIdStafAttribute($value)
    {
        return $value ?? 0;
    }

    public function getIdDokterAttribute($value)
    {
        return $value ?? 0;
    }

    public function getTanggalAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getHasilPemeriksaanAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getRiwayatRekamMedisAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getDiagnosaAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getTindakanAttribute($value)
    {
        return $value ?? 'N/A';
    }

    public function getObatAttribute($value)
    {
        return $value ?? 'N/A';
    }

    // Accessor tambahan untuk format tampilan
    public function getTanggalFormatAttribute()
    {
        return $this->TANGGAL ? 
            Carbon::parse($this->TANGGAL)->format('d/m/Y') : 'N/A';
    }

    public function getTanggalLengkapAttribute()
    {
        return $this->TANGGAL ? 
            Carbon::parse($this->TANGGAL)->format('d F Y') : 'N/A';
    }

    // Mutator untuk sanitasi input
    public function setIdPasienAttribute($value)
    {
        $this->attributes['ID_PASIEN'] = intval($value);
    }

    public function setIdStafAttribute($value)
    {
        $this->attributes['ID_STAF'] = intval($value);
    }

    public function setIdDokterAttribute($value)
    {
        $this->attributes['ID_DOKTER'] = intval($value);
    }

    public function setTanggalAttribute($value)
    {
        $this->attributes['TANGGAL'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setHasilPemeriksaanAttribute($value)
    {
        $this->attributes['HASIL_PEMERIKSAAN'] = trim($value);
    }

    public function setRiwayatRekamMedisAttribute($value)
    {
        $this->attributes['RIWAYAT_REKAM_MEDIS'] = trim($value);
    }

    public function setDiagnosaAttribute($value)
    {
        $this->attributes['DIAGNOSA'] = trim($value);
    }

    public function setTindakanAttribute($value)
    {
        $this->attributes['TINDAKAN'] = trim($value);
    }

    public function setObatAttribute($value)
    {
        $this->attributes['OBAT'] = trim($value);
    }

    // Relasi dengan tabel lain
    public function pasien()
    {
        return $this->belongsTo(PASIEN::class, 'ID_PASIEN', 'ID_PASIEN');
    }

    public function staf()
    {
        return $this->belongsTo(STAF::class, 'ID_STAF', 'ID_STAF');
    }

    public function dokter()
    {
        return $this->belongsTo(DOKTER::class, 'ID_DOKTER', 'ID_DOKTER');
    }

    // Scope untuk query yang sering digunakan
    public function scopeToday($query)
    {
        return $query->whereDate('TANGGAL', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('TANGGAL', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('TANGGAL', Carbon::now()->month)
                    ->whereYear('TANGGAL', Carbon::now()->year);
    }

    public function scopeByPasien($query, $idPasien)
    {
        return $query->where('ID_PASIEN', $idPasien);
    }

    public function scopeByDokter($query, $idDokter)
    {
        return $query->where('ID_DOKTER', $idDokter);
    }

    public function scopeByStaf($query, $idStaf)
    {
        return $query->where('ID_STAF', $idStaf);
    }

    public function scopeByDate($query, $tanggal)
    {
        return $query->whereDate('TANGGAL', $tanggal);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('TANGGAL', [$startDate, $endDate]);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('TANGGAL', '>=', Carbon::now()->subDays($days));
    }

    // Method helper
    public function isToday()
    {
        return $this->TANGGAL && Carbon::parse($this->TANGGAL)->isToday();
    }

    public function isThisWeek()
    {
        return $this->TANGGAL && Carbon::parse($this->TANGGAL)->isCurrentWeek();
    }

    public function isThisMonth()
    {
        return $this->TANGGAL && Carbon::parse($this->TANGGAL)->isCurrentMonth();
    }

    public function getAgeFromDateAttribute()
    {
        if ($this->TANGGAL) {
            return Carbon::parse($this->TANGGAL)->diffInDays(Carbon::now()) . ' hari yang lalu';
        }
        return 'Tidak diketahui';
    }

    // Method untuk mendapatkan rekam medis berdasarkan kriteria
    public static function getRekamMedisByPasien($idPasien, $limit = null)
    {
        $query = self::where('ID_PASIEN', $idPasien)
                    ->orderBy('TANGGAL', 'desc')
                    ->orderBy('ID_REKAM_MEDIS', 'desc');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    public static function getRekamMedisByDokter($idDokter, $tanggal = null)
    {
        $query = self::where('ID_DOKTER', $idDokter);
        
        if ($tanggal) {
            $query->whereDate('TANGGAL', $tanggal);
        }
        
        return $query->orderBy('TANGGAL', 'desc')->get();
    }

    public static function getRecentRekamMedis($days = 7)
    {
        return self::where('TANGGAL', '>=', Carbon::now()->subDays($days))
                  ->orderBy('TANGGAL', 'desc')
                  ->orderBy('ID_REKAM_MEDIS', 'desc')
                  ->get();
    }

    // Method untuk statistik
    public static function getTotalRekamMedisToday()
    {
        return self::whereDate('TANGGAL', Carbon::today())->count();
    }

    public static function getTotalRekamMedisThisMonth()
    {
        return self::whereMonth('TANGGAL', Carbon::now()->month)
                  ->whereYear('TANGGAL', Carbon::now()->year)
                  ->count();
    }

    public static function getRekamMedisCountByDokter($idDokter, $startDate = null, $endDate = null)
    {
        $query = self::where('ID_DOKTER', $idDokter);
        
        if ($startDate && $endDate) {
            $query->whereBetween('TANGGAL', [$startDate, $endDate]);
        }
        
        return $query->count();
    }
}