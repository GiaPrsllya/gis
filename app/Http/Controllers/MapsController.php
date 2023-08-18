<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlackSpot;
use App\Models\Feature;
use App\Models\Kecamatan;
use App\Models\SettingsAdmin;

class MapsController extends Controller
{
    //

    public function index()
    {
        $settings = SettingsAdmin::all();
        $kecamatan = Kecamatan::all();
        $blackspots = BlackSpot::all();
        $features = Feature::all();
        $data = [
            'settings' => $settings,
            'kecamatans' => $kecamatan,
            'blackspots' => $blackspots,
            'features' => $features,
        ];

        return view('map', $data);
    }

    public function navigasi()
    {
        $settings = SettingsAdmin::all();
        $kecamatan = Kecamatan::all();
        $blackspots = BlackSpot::all();
        $features = Feature::all();
        $data = [
            'settings' => $settings,
            'kecamatans' => $kecamatan,
            'blackspots' => $blackspots,
            'features' => $features,
        ];

        return view('map-navigasi', $data);
    }
}
