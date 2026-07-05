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
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id('id_alumni_profiles');
            $table->foreignId('user_id')->constrained('users', 'id_users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->string('fakultas');
            $table->string('program_studi');
            $table->integer('tahun_lulus');
            $table->enum('status_karir', ['Bekerja', 'Lanjut Studi', 'Wirausaha', 'Belum Bekerja']);
            $table->string('avatar_url')->nullable();
            $table->string('telepon')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};
