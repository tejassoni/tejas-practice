<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('roles')->insert([[
            'name' => 'Admin',
            'slug' => 'Admin',
            'description' => 'Admin Role Manager',
        ],[
            'name' => 'Employee',
            'slug' => 'employee',
            'description' => 'Employee Role Manager',
        ]
        ,[
            'name' => 'Student',
            'slug' => 'student',
            'description' => 'Student Role Manager',
        ]]
        );
    }
}
