<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlackSpot;

class BlackSpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jalan' => 'Gedung Sate',
                'latitude' => 107.61864500321215,
                'longitude' => -6.901284292565208,
                'tahun' => 2010,
            ],
            [
                'jalan' => 'Jalan Pasteur',
                'latitude' => 107.59716378661456,
                'longitude' => -6.900179239404963,
                'tahun' => 2005,
            ]
        ];

        foreach ($data as $item) {
            BlackSpot::create($item);
        }
    }
}
