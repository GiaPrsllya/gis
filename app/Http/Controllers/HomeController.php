<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecelakaan;
use App\Models\BlackSpot;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $kecelakaan = Kecelakaan::groupBy('tahun')
            ->selectRaw('sum(jumlah_kecelakaan) as total_kecelakaan')
            ->pluck('total_kecelakaan');
        $total_kendaraan = Kecelakaan::groupBy('tahun')
            ->selectRaw('sum(r2) as total_r2, sum(r4) as total_r4, sum(r6) as total_r6, sum(r2+ r4+ r6) as total_kendaraan, tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        $titikrawan = BlackSpot::all()->count();
        $users = User::all()->count();
        $total_kecelakaan = Kecelakaan::all()->sum('jumlah_kecelakaan');
        $total_md = Kecelakaan::all()->sum('meninggal_dunia');
        $total_lb = Kecelakaan::all()->sum('luka_berat');
        $total_lr = Kecelakaan::all()->sum('luka_ringan');
        $total_korban = $total_md + $total_lb + $total_lr;

        $tahun =  Kecelakaan::groupBy('tahun')->orderBy('tahun', 'desc')->pluck('tahun');

        $data = [
            'title' => 'Dashboard',
            'laporan' => Kecelakaan::all()->count(),
            'kecelakaan' => $kecelakaan,
            'tahun' => $tahun,
            'titikrawan' => $titikrawan,
            'users' => $users,
            'active' => 'dashboard',
            'total_kecelakaan' => $total_kecelakaan,
            'total_korban' => $total_korban,
            'total_md' => $total_md,
            'total_lb' => $total_lb,
            'total_lr' => $total_lr,
            'total_kendaraan' => $total_kendaraan,
        ];

        return view('dashboard', $data);
    }

    public function getMapData()
    {
        $titikrawan = BlackSpot::all();

        return response()->json($titikrawan);
    }
}
