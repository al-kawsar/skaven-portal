<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->name(),
            'nis' => $this->faker->numerify('######'), // 6-digit number
            'nisn' => $nisn = $this->faker->numerify('############'), // 12-digit number
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->streetAddress(),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katholik', 'Hindu', 'Buddha', 'Konghucu']),
            'user_id' => User::create([
                'name' => $name = $this->faker->name,
                'email' => $nisn . "@smk7.com",
                'password' => '123123123',
                'role_id' => 3
            ])->id
        ];
    }
}
