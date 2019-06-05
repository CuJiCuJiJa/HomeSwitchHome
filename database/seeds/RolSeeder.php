<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' 	=> 1,
            'name' 	=> 'administrador'
        ]);

        DB::table('roles')->insert([
            'id' 	=> 2,
            'name' 	=> 'premium'
        ]);

        DB::table('roles')->insert([
            'id' 	=> 3,
            'name' 	=> 'lowcost'
        ]);
    }
}
