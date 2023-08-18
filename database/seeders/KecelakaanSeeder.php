<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecelakaan;

class KecelakaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kecelakaanData = [
            [
                'jalan' => 'Jalan Raya',
                'latitude' => -6.20000000,
                'longitude' => 106.80000000,
                'deskripsi' => 'Kecelakaan di Jalan Raya',
                'r2' => 5,
                'r4' => 3,
                'r6' => 1,
                'korban_jiwa' => 2,
            ],
            [
                'jalan' => 'Jalan Utama',
                'latitude' => -6.30000000,
                'longitude' => 106.90000000,
                'deskripsi' => 'Kecelakaan di Jalan Utama',
                'r2' => 2,
                'r4' => 1,
                'r6' => 0,
                'korban_jiwa' => 1,
            ],

        ];

        foreach ($kecelakaanData as $data) {
            Kecelakaan::create($data);
        }
    }
}
