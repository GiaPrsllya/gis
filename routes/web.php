<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\MapsController;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Auth::routes();

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/map', [MapsController::class, 'index'])->name('map');
Route::get('/navigasi', [MapsController::class, 'navigasi'])->name('navigasi');

// Route::get('/maps', function () {
//     $data['features'] = Feature::all();
//     return view('ol-djikstra', $data);
// });
Route::post('/route', [App\Http\Controllers\MapsController::class, 'calculateRoute'])->name('route');

Route::get('/tentang-dishub', [App\Http\Controllers\TentangController::class, 'tentang'])->name('tentang');

// login
// Route::get('/', [LoginController::class, 'index']);
// Route::get('/login', [LoginController::class, 'index']);

// register
// Route::get('/register', [RegisterController::class, 'index']);

Route::group(['middleware' => 'auth'], function () {

    // dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard/map-data', [App\Http\Controllers\HomeController::class, 'getMapData'])->name('map-data');

    // Users
    Route::resource('users', App\Http\Controllers\UsersController::class);
    // Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role');

    // kecelakaan
    Route::post('kecelakaan/import', [App\Http\Controllers\KecelakaanController::class, 'importfile'])->name('kecelakaan.import');
    Route::resource('kecelakaan', App\Http\Controllers\KecelakaanController::class);
    // Route::get('/kecelakaan', [App\Http\Controllers\KecelakaanController::class, 'index'])->name('kecelakaan');
    Route::get('/laporan-kecelakaan', [App\Http\Controllers\KecelakaanController::class, 'laporan'])->name('laporan-kecelakaan');
    Route::post('/laporan-kecelakaan', [App\Http\Controllers\KecelakaanController::class, 'laporan'])->name('laporan-kecelakaan');

    //titikrawan
    Route::resource('titikrawan', App\Http\Controllers\TitikRawanController::class);
    // Route::get('/titikrawan', [App\Http\Controllers\TitikRawanController::class, 'index'])->name('titikrawan');
    Route::get('/laporan-titikrawan', [App\Http\Controllers\TitikRawanController::class, 'laporan'])->name('laporan-titikrawan');
    Route::post('/laporan-titikrawan', [App\Http\Controllers\TitikRawanController::class, 'laporan'])->name('laporan-titikrawan');

    Route::resource('rute', App\Http\Controllers\RuteController::class);

    // tentang
    Route::resource('tentang', App\Http\Controllers\TentangController::class);
    // Route::get('/tentang', [App\Http\Controllers\TentangController::class, 'index'])->name('tentang');

    // settings
    Route::resource('settings', App\Http\Controllers\SettingsController::class);

    // kecamatan
    Route::resource('kecamatan', App\Http\Controllers\KecamatanController::class);
});
