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
        Schema::create('news', function (Blueprint $table) {
            $table->id('id_news');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['Akademik', 'Karir', 'Acara']);
            $table->text('konten');
            $table->string('gambar_url')->nullable();
            $table->enum('status', ['Diterbitkan', 'Draf'])->default('Draf');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
