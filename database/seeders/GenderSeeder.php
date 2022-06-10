<?php

namespace Database\Seeders;

use App\Traits\SeederDataTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    use SeederDataTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = self::listGenders();

        DB::table('genders')->insert($list);
    }
}
