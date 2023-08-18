<?php

namespace App\Http\Controllers;

use App\Models\SettingsAdmin;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    //
    public function index()
    {
        $data['settings'] = SettingsAdmin::all();

        return view('landing', $data);
    }
}
