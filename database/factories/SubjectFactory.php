<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjectName = ['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika', 'Fisika', 'Kimia'];

        return [
            'kode' => strtoupper($this->faker->unique()->bothify('??###')),
            'guru_id' => Teacher::inRandomOrder()->first()->id,
            'nama' => $name = $this->faker->randomElement($subjectName),
            'slug' => str()->slug($name) . '-' . str()->random(5),
            'deskripsi' => $this->faker->paragraph(),
            'jenis_pelajaran' => $this->faker->randomElement(['Umum', 'Produktif']),
        ];
    }
}
