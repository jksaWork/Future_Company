<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\RealState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class RealStateSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $real =  RealState::factory(3)->create(['category_id' =>1]);

        for ($i=0; $i < 5 ; $i++) {
            DB::table('owners_realstates')->insert(
                ['owner_id' => rand(1, 5), 'realstate_id' => $real->random()->id ,  'month_count' => rand(1, 5)]
            );
        }
        for ($i=0; $i < 12 ; $i++) {
            DB::table('rent_revenues')->insert(
                [
                    'owner_id' => rand(1, 5),
                    'realstate_id' => $real->random()->id ,
                    'month_number' => $i,
                    'status' =>1,
                    'price' => rand(10000, 100000),
                ]
            );
        }

    }
}