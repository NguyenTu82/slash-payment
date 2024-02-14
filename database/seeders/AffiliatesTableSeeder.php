<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('affiliates')->truncate();
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('affiliates')->insert([
                'id' => $faker->uuid,
                'name' => $faker->name,
                'fee' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
