<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_id',
        'latitude',
        'longitude',
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
