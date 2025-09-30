<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [];

        // Create grades 1 to 13
        for ($i = 1; $i <= 13; $i++) {
            $grades[] = [
                'grade' => 'Grade ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all grades at once
        DB::table('grades')->insert($grades);
    }
}
