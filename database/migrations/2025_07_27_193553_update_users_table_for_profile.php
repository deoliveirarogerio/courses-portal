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
            // Atualizar o campo type para incluir 'aluno' e 'instrutor'
            $table->enum('type', ['admin', 'user', 'aluno', 'instrutor'])->default('aluno')->change();

            // Mudar status de integer para enum string
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['admin', 'user'])->default('user')->change();
            $table->integer('status')->default(0)->change();
        });
    }
};
