<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'jumlah_blackspot',
    ];

    public function coordinates()
    {
        return $this->hasMany(Coordinate::class);
    }
}
