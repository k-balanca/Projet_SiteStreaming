<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('film', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('affiche')->nullable();
            $table->integer('note')->nullable();

            // Clé étrangère corrigée
            $table->foreignId('genre_id')
                  ->constrained('genre') // <-- nom exact de ta table
                  ->cascadeOnDelete();   // optionnel mais recommandé
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('film');
    }
};