<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id'    => 1,
                'latitude'   => 52.37052,
                'longitude'  => 9.73322,
                'name'       => 'Germany'
            ]
        ];

        DB::table('user_places')->insert($data);
    }
}

