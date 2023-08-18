<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsAdmin;

class SettingsController extends Controller
{
    //
    public function index()
    {
        return view('settings');
    }

    public function store(Request $request)
    {
        // validate
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'webaddress' => 'required',
            'desc' => 'required',
        ]);

        $address = $request->address;
        $email = $request->email;
        $webaddress = $request->webaddress;
        $desc = $request->desc;

        // update
        SettingsAdmin::where('id', '1')->update(['option_value' => $address]);
        SettingsAdmin::where('id', '2')->update(['option_value' => $email]);
        SettingsAdmin::where('id', '3')->update(['option_value' => $webaddress]);
        SettingsAdmin::where('id', '4')->update(['option_value' => $desc]);

        session()->flash('success', 'Data berhasil diubah');
        return redirect('/tentang');
    }
}
