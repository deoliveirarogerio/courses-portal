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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->text('curriculum')->nullable();
            $table->string('duration')->nullable();
            $table->enum('difficulty_level', ['iniciante', 'intermediario', 'avancado'])->default('iniciante');
            $table->json('tags')->nullable(); // Tags/categorias
            $table->boolean('is_featured')->default(false); // Curso em destaque
            $table->integer('total_students')->default(0); // Total de alunos matriculados
            $table->decimal('rating', 3, 2)->default(0.00); // Avaliação média
            $table->integer('total_reviews')->default(0);
            $table->decimal('price', 8, 2);
            $table->enum('status', ['ativo', 'inativo', 'rascunho', 'Não informado'])->default('Não informado');
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->integer('remaining_slots')->default(0);
            $table->integer('max_students')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
