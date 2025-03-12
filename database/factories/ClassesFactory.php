<?php

namespace Database\Factories;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;

        // Define jurusan options
        $jurusan = ['RPL', 'AP', 'PS'];

        // Define the class numbering
        $major = $this->faker->randomElement($jurusan);
        $number = $this->faker->numberBetween(1, 3); // Assuming 1 to 3 classes per major

        return [
            'nama' => "$major $number",
            'kode' => strtoupper($this->faker->unique()->bothify('??###')),
            'wali_kelas_id' => Teacher::inRandomOrder()->first()->id,
            'tahun_ajaran' => $this->faker->randomElement([
                "$currentYear/$nextYear",
                "$nextYear/" . ($nextYear + 1),
                "$currentYear/" . ($currentYear + 2),
                "$currentYear/" . ($currentYear + 1)
            ]),
            'tingkat_kelas' => $this->faker->numberBetween(1, 3), // Misalnya: 1-12 untuk SD-SMA
            'jumlah_siswa' => $this->faker->numberBetween(20, 40),
        ];
    }
}
