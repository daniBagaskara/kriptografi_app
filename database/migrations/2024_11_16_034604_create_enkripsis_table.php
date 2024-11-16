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
        Schema::create('enkripsis', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->enum('data_type', ['text', 'file', 'image']); // Jenis data
            $table->text('original_data')->nullable(); // Data asli (untuk teks)
            $table->text('encrypted_data')->nullable(); // Data terenkripsi (untuk teks)
            $table->string('file_path')->nullable(); // Path file asli (untuk file)
            $table->string('encrypted_file_path')->nullable(); // Path file terenkripsi
            $table->binary('image_data')->nullable(); // Gambar asli (untuk gambar)
            $table->binary('encrypted_image_data')->nullable(); // Gambar terenkripsi
            $table->string('algorithm')->nullable(); // Nama algoritma enkripsi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enkripsis');
    }
};
