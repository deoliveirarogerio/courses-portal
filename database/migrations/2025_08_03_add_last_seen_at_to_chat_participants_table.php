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
        Schema::table('chat_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_participants', 'last_seen_at')) {
                $table->timestamp('last_seen_at')->nullable()->after('joined_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_participants', function (Blueprint $table) {
            if (Schema::hasColumn('chat_participants', 'last_seen_at')) {
                $table->dropColumn('last_seen_at');
            }
        });
    }
};