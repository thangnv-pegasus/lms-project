<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 2020; $i < 2025; $i++) {
            AcademicYear::create([
                'name' => $i.' - '.($i + 4),
                'slug' => Str::slug($i.' - '.($i + 4)),
                'start_year' => $i,
                'end_year' => $i + 4,
                'status' => 1,
            ]);
        }
    }
}
