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
        Schema::table('courses', function (Blueprint $table) {
            // Adicionar campos adicionais
            $table->string('image')->nullable()->after('description');
            $table->text('curriculum')->nullable()->after('image'); // Currículo do curso
            $table->string('duration')->nullable()->after('curriculum'); // Ex: "40 horas"
            $table->enum('difficulty_level', ['iniciante', 'intermediario', 'avancado'])->default('iniciante')->after('duration');
            $table->json('tags')->nullable()->after('instructor'); // Tags/categorias
            $table->boolean('is_featured')->default(false)->after('tags'); // Curso em destaque
            $table->integer('total_students')->default(0)->after('is_featured'); // Total de alunos matriculados
            $table->decimal('rating', 3, 2)->default(0.00)->after('total_students'); // Avaliação média
            $table->integer('total_reviews')->default(0)->after('rating'); // Total de avaliações

            // Alterar campos existentes
            $table->enum('status', ['ativo', 'inativo', 'rascunho'])->default('rascunho')->change();
            $table->integer('max_students')->default(50)->after('remaining_slots'); // Máximo de alunos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'curriculum',
                'duration',
                'difficulty_level',
                'instructor',
                'tags',
                'is_featured',
                'total_students',
                'rating',
                'total_reviews',
                'max_students'
            ]);

            $table->enum('status', ['sim', 'não'])->default('não')->change();
        });
    }
};
