<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contests')->insert([
            [
                'name' => 'Student Energy Challenge',
            ],
            [
                'name' => 'Student Energy Challenge-Junior',
            ],
        ]);
    }
}
