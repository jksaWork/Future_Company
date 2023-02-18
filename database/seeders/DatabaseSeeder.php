<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Area;
use App\Models\Client;
use App\Models\Owner;
use App\Models\RealState;
use App\Models\RealStateCategory;
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
        $this->call(LaraTrustSeeder::class);
        Admin::factory(1)->create();
        Owner::factory(1)->create([
            'email' => 'owner@gmail.com',
        ]);
        Owner::factory(20)->create();
        RealStateCategory::factory()->create([
            'name' => 'شقق للبيع',
            'type' => 'sale',
        ]);

        RealStateCategory::factory()->create([
            'name' => 'متاجر للاجار',
            'type' => 'rent',
        ]);

        $this->call(RealStateSedder::class);

        // RealState::factory()->create();


    }
}
