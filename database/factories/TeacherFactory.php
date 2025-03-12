<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        $roles = [
            'Guru',
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Guru Honorer',
            'Guru PNS'
        ];


        return [
            'name' => $name = $this->faker->name(),
            'nip' => $nip = $this->faker->unique()->numerify('##################'), // 18-digit number
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katholik', 'Hindu', 'Buddha', 'Konghucu']),
            'pendidikan_terakhir' => $this->faker->randomElement(['S1', 'S2', 'S3']),
            'jurusan' => $this->faker->randomElement(['Pendidikan', 'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Kimia', 'Biologi']),
            'no_telepon' => $this->faker->unique()->phoneNumber(),
            'tanggal_masuk' => $this->faker->date(),
            'gaji' => $this->faker->randomDigitNotZero(),
            'status' => $this->faker->randomElement($roles),
            'tanggal_pensiun' => $this->faker->optional()->date(),
            'alamat_email_darurat' => $this->faker->optional()->safeEmail(),
            'user_id' => User::create([
                'name' => $name,
                'email' => $nip . "@smk7.com",
                'password' => '123123123',
                'role_id' => 2
            ])->id
        ];
    }
}
