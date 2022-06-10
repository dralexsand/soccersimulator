<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CardSeeder::class,
            GenderSeeder::class,
            EntitySeeder::class,
            ChanceSeeder::class,
            AmpluaSeeder::class,
        ]);

        \App\Models\Stadium::factory(10)->create();
        \App\Models\Referee::factory(50)->create();
        \App\Models\Team::factory(20)->create();


        $this->call([
            PlayerSeeder::class,
            FanSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}
