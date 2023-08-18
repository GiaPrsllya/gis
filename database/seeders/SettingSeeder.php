<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingsAdmin;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'option_name' => 'address',
                'option_value' => 'Jln Politeknik SubangSubang'
            ],
            [
                'option_name' => 'email',
                'option_value' => 'admin@gov.id'
            ],
            [
                'option_name' => 'webaddress',
                'option_value' => 'dishub.gov.id'
            ],
            [
                'option_name' => 'Desc',
                'option_value' => 'loream ipsum dolor sit amet'
            ]
        ];

        foreach ($data as $key => $value) {
            SettingsAdmin::create($value);
        }
    }
}
