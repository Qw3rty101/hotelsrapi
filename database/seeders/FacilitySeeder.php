<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_facilities')->insert([
            'name_facility' => 'wifi',
            'icon_facility' => 'wifi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
