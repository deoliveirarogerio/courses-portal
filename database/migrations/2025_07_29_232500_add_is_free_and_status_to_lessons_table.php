<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('order');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->after('is_free');
            $table->text('content')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['is_free', 'status', 'content']);
        });
    }
};
