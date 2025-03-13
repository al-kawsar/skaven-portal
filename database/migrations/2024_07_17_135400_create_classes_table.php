<?php

use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('kode', 10)->unique();
            $table->foreignIdFor(Teacher::class, 'wali_kelas_id')->constrained('teachers')->cascadeOnUpdate()->cascadeOnDelete(); // Foreign key untuk wali kelas
            $table->string('tahun_ajaran', 9); // Contoh: "2023/2024"
            $table->integer('tingkat_kelas');
            $table->integer('jumlah_siswa')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
