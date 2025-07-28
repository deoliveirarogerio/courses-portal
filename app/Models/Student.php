<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name', // Manter por compatibilidade
        'email', // Manter por compatibilidade
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
        'allow_messages',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'interests' => 'array',
        'email_notifications' => 'boolean',
        'course_reminders' => 'boolean',
        'progress_updates' => 'boolean',
        'marketing_emails' => 'boolean',
        'public_profile' => 'boolean',
        'show_progress' => 'boolean',
        'show_certificates' => 'boolean',
        'allow_messages' => 'boolean',
    ];

    /**
     * Valores padrão
     */
    protected $attributes = [
        'experience_level' => 'iniciante',
        'preferred_time' => 'noite',
        'weekly_goal_hours' => 20,
        'email_notifications' => true,
        'course_reminders' => true,
        'progress_updates' => false,
        'marketing_emails' => false,
        'public_profile' => true,
        'show_progress' => true,
        'show_certificates' => false,
        'allow_messages' => false,
        'status' => 'active',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Enrollments (matrículas)
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'enrollments')
            ->withPivot(['progress', 'last_accessed', 'next_lesson', 'is_favorite', 'has_certificate'])
            ->withTimestamps();
    }

    /**
     * Accessor para avatar com fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(storage_path('app/public/avatars/' . $this->avatar))) {
            return asset('storage/avatars/' . $this->avatar);
        }

        // Usar nome do usuário relacionado ou nome do student
        $name = $this->user ? $this->user->name : $this->name;
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0d6efd&color=fff&size=200';
    }

    /**
     * Accessor para idade calculada
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * Accessor para nível de experiência formatado
     */
    public function getExperienceLevelLabelAttribute(): string
    {
        return match($this->experience_level) {
            'iniciante' => 'Iniciante',
            'intermediario' => 'Intermediário',
            'avancado' => 'Avançado',
            default => 'Não informado'
        };
    }

    /**
     * Accessor para horário preferido formatado
     */
    public function getPreferredTimeLabelAttribute(): string
    {
        return match($this->preferred_time) {
            'manha' => 'Manhã (6h - 12h)',
            'tarde' => 'Tarde (12h - 18h)',
            'noite' => 'Noite (18h - 22h)',
            'madrugada' => 'Madrugada (0h - 6h)',
            default => 'Não informado'
        };
    }

    /**
     * Accessor para data de nascimento formatada
     */
    public function getBirthDateFormattedAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->format('d/m/Y') : null;
    }

    /**
     * Scope para estudantes com perfil público
     */
    public function scopePublicProfile($query)
    {
        return $query->where('public_profile', true);
    }

    /**
     * Scope para estudantes ativos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
