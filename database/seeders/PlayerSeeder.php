<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Traits\SeederDataTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class PlayerSeeder extends Seeder
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

        $ampluaCounts = [
            self::getItemByName('goalkeeper_count_in_team'),
            self::getItemByName('defender_count_in_team'),
            self::getItemByName('midfielder_count_in_team'),
            self::getItemByName('forward_count_in_team')
        ];

        foreach ($teamList as $team) {
            $players = [];
            $jerseyRange = range(1, 100);

            foreach ($ampluaCounts as $keyApmlua => $ampluaCount) {
                $i = 1;

                while ($i <= rand($ampluaCount['min'], $ampluaCount['max'])) {
                    $jersey = $jerseyRange[rand(0, count($jerseyRange) - 1)];

                    $players[] = [
                        'team_id' => $team->id,
                        'gender_id' => 1,
                        'age' => rand(19, 35),
                        'first_name' => $faker->firstNameMale(),
                        'last_name' => $faker->lastName(),
                        'amplua' => (int)$keyApmlua + 1,
                        'jersey' => $jersey,
                        'is_captain' => false,
                    ];

                    $key = array_search($jersey, $jerseyRange);
                    unset($jerseyRange[$key]);
                    $jerseyRange = array_values($jerseyRange);

                    $i++;
                }
            }

            $keCaptain = rand(0, count($players) - 1);
            $players[$keCaptain]['is_captain'] = true;

            DB::table('players')->insert($players);
        }
    }
}
