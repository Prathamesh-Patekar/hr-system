<?php

use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('assets')->insert([
            'name' => 'personal',
            'status' => 1,
            'device' => 7,
        ]);
    }
}
