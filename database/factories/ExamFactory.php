<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 'student_id' => Student::inRandomOrder()->first()->id,
        // 'student_id' => Student::inRandomOrder()->first()->id,
        return [
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'student_id' => Student::inRandomOrder()->first()->id,
            'nilai' => $this->faker->numberBetween(70, 100),
            'tanggal_nilai' => $this->faker->date(),
        ];
    }
}
