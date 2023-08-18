<?php

namespace App\Http\Controllers;

use App\Models\BlackSpot;
use App\Models\Coordinate;
use App\Models\Feature;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['blackspots'] = BlackSpot::all();
        $data['features'] = Feature::all();
        return view('kelola.rute.index', $data);
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
        $request->validate([
            'name' => 'required',
            'jumlah_blackspot' => 'required',
            'latitude' => 'required|array',
            'longitude' => 'required|array',
        ]);

        // make new feature
        $feature = Feature::create([
            'name' => $request->name,
            'jumlah_blackspot' => $request->jumlah_blackspot,
        ]);

        // foreach length request longitude[]
        for ($i = 0; $i < count($request->longitude); $i++) {
            // insert into feature coordinate
            $feature->coordinates()->create([
                'latitude' => $request->latitude[$i],
                'longitude' => $request->longitude[$i],
            ]);
        }

        // create geojson from all feature
        $geojson = [
            'type' => 'FeatureCollection',
            "crs" => [
                "type" => "name",
                "properties" => [
                    "name" => "urn:ogc:def:crs:OGC:1.3:CRS84"
                ]
            ],
            'features' => [],
        ];

        // foreach feature
        foreach (Feature::all() as $feature) {
            // make new feature
            $geojson_feature = [
                'type' => 'Feature',
                'properties' => [
                    'name' => $feature->name,
                    'jumlah_blackspot' => $feature->jumlah_blackspot,
                ],
                'geometry' => [
                    'type' => 'LineString',
                    'coordinates' => [],
                ],
            ];

            // foreach coordinate
            foreach ($feature->coordinates as $coordinate) {
                // push coordinate to feature
                array_push($geojson_feature['geometry']['coordinates'], [
                    (float) $coordinate->longitude,
                    (float) $coordinate->latitude,
                ]);
            }

            // push feature to geojson
            array_push($geojson['features'], $geojson_feature);
        }

        // save geojson to file
        $filename = 'routesubang.geojson';
        $filepath = public_path('geojson/' . $filename);
        file_put_contents($filepath, json_encode($geojson));

        return redirect()->route('rute.index')->with('success', 'Berhasil menambahkan rute baru');

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Feature::find($id)->delete();
        return redirect()->route('rute.index')->with('success', 'Berhasil menghapus rute');
    }
}
