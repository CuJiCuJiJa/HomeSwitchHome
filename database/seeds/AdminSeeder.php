<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' 	    => 1,
            'name' 	    => 'admin',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('administrador'),
            'role_id'   => 1,
        ]);
    }
}

