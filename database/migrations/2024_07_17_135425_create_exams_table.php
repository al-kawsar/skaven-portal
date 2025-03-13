<?php

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class, 'student_id')->constrained('students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Subject::class, 'subject_id')->constrained('subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('nilai');
            $table->date('tanggal_nilai');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
