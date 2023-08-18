<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['kecamatans'] = \App\Models\Kecamatan::all();

        return view('kelola.kecamatan', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        \App\Models\Kecamatan::create($request->all());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $kecamatan = \App\Models\Kecamatan::find($id);
        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $kecamatan = \App\Models\Kecamatan::find($id);
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan deleted successfully');
    }
}
