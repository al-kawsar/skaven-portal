<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nip', 18)->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('agama', 20);
            $table->string('pendidikan_terakhir', 50)->nullable();
            $table->string('jurusan', 50);
            $table->string('no_telepon', 25)->unique();
            $table->date('tanggal_masuk');
            $table->integer('gaji')->nullable();
            $table->string('status');
            $table->date('tanggal_pensiun')->nullable();
            $table->string('no_telepon_darurat', 15)->nullable();
            $table->string('alamat_email_darurat')->nullable();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
