<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiporecetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tiporeceta');
            $table->string('color_hex')->default('#000000');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiporecetas');
    }
};
