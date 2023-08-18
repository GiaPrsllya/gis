<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'jalan',
        'longitude',
        'latitude',
        'tahun',
        'keterangan',
    ];
}
