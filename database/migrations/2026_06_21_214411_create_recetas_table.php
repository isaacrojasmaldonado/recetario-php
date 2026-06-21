<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_recetas');
            $table->string('email');
            $table->foreignId('id_tiporeceta')->constrained('tiporecetas')->onDelete('cascade');
            $table->enum('dificultad', ['fácil', 'media', 'difícil']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
