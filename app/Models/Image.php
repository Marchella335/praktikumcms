<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
      
   protected $table = 'IMAGES'; // HARUS SAMA dengan nama tabel di Oracle (huruf besar)

    protected $fillable = [
        'title',
        'image_path',
    ];
}
