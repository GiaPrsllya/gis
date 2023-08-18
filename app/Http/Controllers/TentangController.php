<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsAdmin;
use App\Models\Kecamatan;
use App\Models\BlackSpot;

class TentangController extends Controller
{
    //
    public function index()
    {
        $settings = SettingsAdmin::all();

        $data = [
            'settings' => $settings
        ];

        return view('tentang', $data);
    }

    public function tentang()
    {
        $settings = SettingsAdmin::all();
        $kecamatan = Kecamatan::all();
        $blackspots = BlackSpot::all();
        $data = [
            'settings' => $settings,
            'kecamatans' => $kecamatan,
            'blackspots' => $blackspots
        ];

        return view('tentang_dishub', $data);
    }
}
