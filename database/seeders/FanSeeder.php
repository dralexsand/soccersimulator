<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Traits\SeederDataTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FanSeeder extends Seeder
{
    use SeederDataTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $teamList = Team::get();

        $chanceFanFemale = self::getItemByName('fan_female_chance');
        $arrChance = str_split($chanceFanFemale['value'], 1);

        foreach ($teamList as $team) {
            $fans = [];

            $i = 1;
            while ($i < rand(100, 200)) {
                $gender = (int)$arrChance[rand(0, count($arrChance) - 1)];

                $fans[] = [
                    'team_id' => $team->id,
                    'gender_id' => $gender,
                    'age' => rand(17, 67),
                    'first_name' => $gender === 1 ? $faker->firstNameMale() : $faker->firstNameFemale(),
                    'last_name' => $faker->lastName(),
                ];

                $i++;
            }

            DB::table('fans')->insert($fans);
        }
    }
}
