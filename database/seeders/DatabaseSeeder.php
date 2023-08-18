<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // make admin
        User::create([
            'name' => 'Admin',
            'email' => 'lakadishub@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $this->call([
            SettingSeeder::class,
        ]);
    }
}
