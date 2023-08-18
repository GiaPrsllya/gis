<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecelakaan;
use Maatwebsite\Excel\Facades\Excel;

class KecelakaanController extends Controller
{
    //
    public function index()
    {
        $kecelakaan = Kecelakaan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        $data = [
            'kecelakaan' => $kecelakaan
        ];

        return view('kelola/kecelakaan', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            // regex tahun yyyy
            'tahun' => 'required|regex:/^[0-9]{4}$/',
            'bulan' => 'required',
            'meninggal_dunia' => 'required',
            'luka_berat' => 'required',
            'luka_ringan' => 'required',
            'rugi_materi' => 'required',
            'r2' => 'required',
            'r4' => 'required',
            'r6' => 'required',
        ]);

        Kecelakaan::create($request->all());

        return redirect()->route('kecelakaan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|regex:/^[0-9]{4}$/',
            'bulan' => 'required',
            'meninggal_dunia' => 'required',
            'luka_berat' => 'required',
            'luka_ringan' => 'required',
            'rugi_materi' => 'required',
            'r2' => 'required',
            'r4' => 'required',
            'r6' => 'required',
        ]);

        $kecelakaan = Kecelakaan::find($id);
        $kecelakaan->update($request->all());

        return redirect()->route('kecelakaan.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $kecelakaan = Kecelakaan::find($id);

        $kecelakaan->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect('/kecelakaan');
    }

    public function laporan(Request $request)
    {
        if ($request->tahun) {
            $tahun = Kecelakaan::get();
            $kecelakaan = Kecelakaan::selectRaw('*')
                ->where('tahun', $request->tahun)
                ->get();

            $data = [
                'tahun' => array_unique($tahun->pluck('tahun')->toArray()),
                'kecelakaan' => $kecelakaan,
                'periode' => $request->tahun
            ];

            return view('laporan/kecelakaan', $data);
        }

        $kecelakaan = Kecelakaan::orderBy('tahun', 'desc')->get();
        // get min and max year
        $tahun = Kecelakaan::selectRaw('min(tahun) as min, max(tahun) as max')->first();        
        $data = [
            'tahun' => array_unique($kecelakaan->pluck('tahun')->toArray()),
            'kecelakaan' => $kecelakaan,
            'periode' => $tahun->min . ' - ' . $tahun->max
        ];

        return view('laporan/kecelakaan', $data);
    }

    public function importfile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file')->store('kecelakaan');

        try {
            Excel::import(new \App\Imports\KecelakaansImport, $file);
        } catch (\Exception $e) {
            return redirect()->route('kecelakaan.index')
                ->with('error', 'Terjadi kesalahan saat mengunggah file. Pastikan file yang diunggah sesuai dengan format yang ditentukan.');
        }

        return redirect()->route('kecelakaan.index')->with('success', 'Data berhasil diimport');
    }
}
