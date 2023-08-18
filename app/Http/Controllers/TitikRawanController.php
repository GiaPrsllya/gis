<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlackSpot;

class TitikRawanController extends Controller
{
    //
    public function index()
    {
        $titikrawan = BlackSpot::all();
        $data = [
            'titikrawan' => $titikrawan
        ];

        return view('kelola/titikrawan', $data);
    }

    public function create()
    {
        //
        return view('kelola/blackspot/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jalan' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'tahun' => 'required',
            'keterangan' => 'required',
        ]);

        // store image
        $imageName = $request->thumbnail->store('thumbnail');

        // store data
        $blackspot = new BlackSpot();
        $blackspot->thumbnail = $imageName;
        $blackspot->jalan = $request->jalan;
        $blackspot->longitude = $request->longitude;
        $blackspot->latitude = $request->latitude;
        $blackspot->tahun = $request->tahun;
        $blackspot->keterangan = $request->keterangan;
        $blackspot->save();

        session()->flash('success', 'Data berhasil ditambahkan');
        return redirect('/titikrawan');
    }

    public function edit($id)
    {
        $blackspot = BlackSpot::find($id);
        $data = [
            'titikrawan' => $blackspot
        ];

        return view('kelola/blackspot/edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jalan' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'tahun' => 'required',
            'keterangan' => 'required',
        ]);

        $blackspot = BlackSpot::find($id);
        $blackspot->jalan = $request->jalan;
        $blackspot->longitude = $request->longitude;
        $blackspot->latitude = $request->latitude;
        $blackspot->tahun = $request->tahun;
        $blackspot->keterangan = $request->keterangan;

        if ($request->thumbnail != null) {
            $imageName = $request->thumbnail->store('thumbnail');
            $blackspot->thumbnail = $imageName;
        }

        $blackspot->save();

        session()->flash('success', 'Data berhasil diubah');
        return redirect('/titikrawan');
    }

    public function destroy($id)
    {
        BlackSpot::find($id)->delete();

        session()->flash('success', 'Data berhasil dihapus');
        return redirect('/titikrawan');
    }

    public function laporan(Request $request)
    {
        if ($request->tahun) {

            $data = [
                'tahun' => BlackSpot::all(),
                'titikrawan' => BlackSpot::where('tahun', $request->tahun)->get()
            ];

            return view('laporan/titikrawan', $data);
        }

        $titikrawan = BlackSpot::all();
        $data = [
            'tahun' => $titikrawan,
            'titikrawan' => $titikrawan
        ];


        return view('laporan/titikrawan', $data);
    }
}
