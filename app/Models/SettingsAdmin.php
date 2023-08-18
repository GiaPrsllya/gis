<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsAdmin extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'option_name',
        'option_value'
    ];
}
