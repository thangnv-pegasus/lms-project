<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2024);
        $endYear = $startYear + 4;

        return [
            'name' => $startYear . ' - ' . $endYear,
            'slug' => Str::slug($startYear . ' - ' . $endYear),
            'start_year' => $startYear,
            'end_year' => $endYear,
            'status' => 1
        ];
    }
}
