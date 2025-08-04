<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Dropar tabelas existentes do chat na ordem correta (respeitando foreign keys)
        Schema::dropIfExists('chat_message_reads');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_participants');
        Schema::dropIfExists('chat_rooms');
        Schema::dropIfExists('chat_conversations'); // se existir
    }

    public function down()
    {
        // Não fazer nada
    }
};