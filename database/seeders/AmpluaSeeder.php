<?php

namespace Database\Seeders;

use App\Traits\SeederDataTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmpluaSeeder extends Seeder
{
    use SeederDataTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = self::listAmpluas();

        DB::table('ampluas')->insert($list);
    }
}
