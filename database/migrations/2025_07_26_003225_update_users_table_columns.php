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
        Schema::table('users', function (Blueprint $table) {
            // Alterar o campo type para incluir mais opções
            $table->enum('type', ['admin', 'user', 'aluno', 'instrutor'])->default('aluno')->change();

            // Alterar o campo status de integer para string enum
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverter as alterações
            $table->enum('type', ['admin', 'user'])->default('user')->change();
            $table->integer('status')->default(0)->change();
        });
    }
};
