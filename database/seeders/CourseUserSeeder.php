<?php

namespace Database\Seeders;

use App\Models\CourseUser;
use Illuminate\Database\Seeder;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseUser::factory(50)->create();
    }
}
