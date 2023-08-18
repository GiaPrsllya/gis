<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'bulan',
        'meninggal_dunia',
        'luka_berat',
        'luka_ringan',
        'rugi_materi',
        'r2',
        'r4',
        'r6',        
        'jumlah_kecelakaan',
    ];
}
