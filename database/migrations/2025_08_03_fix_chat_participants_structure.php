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
        // Verificar se a tabela tem conversation_id em vez de room_id
        if (Schema::hasColumn('chat_participants', 'conversation_id')) {
            Schema::table('chat_participants', function (Blueprint $table) {
                // Remover foreign key se existir
                $table->dropForeign(['conversation_id']);
                
                // Renomear coluna
                $table->renameColumn('conversation_id', 'room_id');
                
                // Adicionar foreign key para chat_rooms
                $table->foreign('room_id')->references('id')->on('chat_rooms')->onDelete('cascade');
            });
        }
        
        // Adicionar colunas que podem estar faltando
        Schema::table('chat_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_participants', 'is_admin')) {
                $table->boolean('is_admin')->default(false);
            }
            if (!Schema::hasColumn('chat_participants', 'is_muted')) {
                $table->boolean('is_muted')->default(false);
            }
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
            if (Schema::hasColumn('chat_participants', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->renameColumn('room_id', 'conversation_id');
                $table->foreign('conversation_id')->references('id')->on('chat_conversations')->onDelete('cascade');
            }
            
            $table->dropColumn(['is_admin', 'is_muted', 'last_seen_at']);
        });
    }
};