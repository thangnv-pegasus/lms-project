<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 65; $i < 70; $i++) {
            $department = Department::inRandomOrder()->first();
            $academic = AcademicYear::inRandomOrder()->first();
            Classes::create([
                'name' => $i.chr($i),
                'slug' => Str::slug($i.chr($i)),
                'department_id' => $department->id,
                'academic_year_id' => $academic->id,
            ]);
        }
    }
}
