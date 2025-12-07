<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            ['user_type' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['user_type' => 'Teacher', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
