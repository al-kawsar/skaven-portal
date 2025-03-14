<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjectName = ['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika', 'Fisika', 'Kimia'];

        for ($i = 0; $i < count($subjectName); $i++) {
            $name = $subjectName[$i];
            Subject::create([
                'kode' => strtoupper(str()->random(5)),
                'nama' => $name,
                'slug' => str()->slug($name),
                'deskripsi' => "Lorem Ipsum lorong 254/12 A",
                'jenis_pelajaran' => 'Umum',
                'guru_id' => Teacher::inRandomOrder()->first()->id,
            ]);
        }
    }
}
