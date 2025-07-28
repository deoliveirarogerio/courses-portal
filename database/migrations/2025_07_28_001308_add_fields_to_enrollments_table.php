<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Adiciona os campos somente se ainda não existem (previne erro ao rodar várias vezes)
            if (!Schema::hasColumn('enrollments', 'progress')) {
                $table->integer('progress')->default(0)->after('course_id');
            }
            if (!Schema::hasColumn('enrollments', 'last_accessed')) {
                $table->timestamp('last_accessed')->nullable()->after('progress');
            }
            if (!Schema::hasColumn('enrollments', 'next_lesson')) {
                $table->string('next_lesson')->nullable()->after('last_accessed');
            }
            if (!Schema::hasColumn('enrollments', 'is_favorite')) {
                $table->boolean('is_favorite')->default(false)->after('next_lesson');
            }
            if (!Schema::hasColumn('enrollments', 'has_certificate')) {
                $table->boolean('has_certificate')->default(false)->after('is_favorite');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'progress')) {
                $table->dropColumn('progress');
            }
            if (Schema::hasColumn('enrollments', 'last_accessed')) {
                $table->dropColumn('last_accessed');
            }
            if (Schema::hasColumn('enrollments', 'next_lesson')) {
                $table->dropColumn('next_lesson');
            }
            if (Schema::hasColumn('enrollments', 'is_favorite')) {
                $table->dropColumn('is_favorite');
            }
            if (Schema::hasColumn('enrollments', 'has_certificate')) {
                $table->dropColumn('has_certificate');
            }
        });
    }
};
