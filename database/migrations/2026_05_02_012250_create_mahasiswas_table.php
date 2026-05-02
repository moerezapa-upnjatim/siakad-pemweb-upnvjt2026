<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 10)->unique();
            $table->string('nama', 100);
            $table->string('email')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('foto')->nullable();
            $table->string('prodi', 50);
            $table->year('angkatan');
            $table->decimal('ipk', 3, 2)->default(0.00);
            $table->enum('status', ['aktif', 'cuti', 'lulus', 'do'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
