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
        Schema::table('students', function (Blueprint $table) {
            // Adicionar relacionamento com users
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');

            // Remover campos duplicados que já existem em users
            // Manter name e email por compatibilidade por enquanto, mas adicionar campos novos

            // Informações pessoais adicionais
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
            $table->string('city')->nullable()->after('birth_date');
            $table->string('state')->nullable()->after('city');
            $table->string('profession')->nullable()->after('state');
            $table->text('bio')->nullable()->after('profession');
            $table->string('avatar')->nullable()->after('bio');

            // Preferências de aprendizado
            $table->json('interests')->nullable()->after('avatar'); // Array de interesses
            $table->enum('experience_level', ['iniciante', 'intermediario', 'avancado'])->default('iniciante')->after('interests');
            $table->enum('preferred_time', ['manha', 'tarde', 'noite', 'madrugada'])->default('noite')->after('experience_level');
            $table->integer('weekly_goal_hours')->default(20)->after('preferred_time');

            // Configurações de notificações
            $table->boolean('email_notifications')->default(true)->after('weekly_goal_hours');
            $table->boolean('course_reminders')->default(true)->after('email_notifications');
            $table->boolean('progress_updates')->default(false)->after('course_reminders');
            $table->boolean('marketing_emails')->default(false)->after('progress_updates');

            // Configurações de privacidade
            $table->boolean('public_profile')->default(true)->after('marketing_emails');
            $table->boolean('show_progress')->default(true)->after('public_profile');
            $table->boolean('show_certificates')->default(false)->after('show_progress');
            $table->boolean('allow_messages')->default(false)->after('show_certificates');

            // Mudar status de integer para enum string
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'phone',
                'birth_date',
                'city',
                'state',
                'profession',
                'bio',
                'avatar',
                'interests',
                'experience_level',
                'preferred_time',
                'weekly_goal_hours',
                'email_notifications',
                'course_reminders',
                'progress_updates',
                'marketing_emails',
                'public_profile',
                'show_progress',
                'show_certificates',
                'allow_messages'
            ]);

            $table->integer('status')->default(0)->change();
        });
    }
};
