<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'curriculum',
        'duration',
        'difficulty_level',
        'instructor',
        'tags',
        'price',
        'status',
        'registration_start',
        'registration_end',
        'remaining_slots',
        'max_students',
        'is_featured',
        'total_students',
        'rating',
        'total_reviews',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'registration_start' => 'date',
        'registration_end' => 'date',
        'tags' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Relacionamento com matrículas
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class, 'enrollments')
            ->withPivot(['progress', 'last_accessed', 'next_lesson', 'is_favorite', 'has_certificate'])
            ->withTimestamps();
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    /**
     * Accessor para imagem com fallback
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/courses/' . $this->image))) {
            return asset('storage/courses/' . $this->image);
        }

        return 'https://via.placeholder.com/400x300/0d6efd/ffffff?text=' . urlencode($this->title);
    }

    /**
     * Accessor para nível de dificuldade formatado
     */
    public function getDifficultyLevelLabelAttribute(): string
    {
        return match($this->difficulty_level) {
            'iniciante' => 'Iniciante',
            'intermediario' => 'Intermediário',
            'avancado' => 'Avançado',
            default => 'Não informado'
        };
    }

    /**
     * Accessor para status formatado
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'ativo' => 'Ativo',
            'inativo' => 'Inativo',
            'rascunho' => 'Rascunho',
            default => 'Não informado'
        };
    }

    /**
     * Accessor para cor do badge do status
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'ativo' => 'success',
            'inativo' => 'danger',
            'rascunho' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Verificar se as inscrições estão abertas
     */
    public function isRegistrationOpen(): bool
    {
        $now = now();

        if (!$this->registration_start || !$this->registration_end) {
            return $this->status === 'ativo';
        }

        return $this->status === 'ativo'
            && $now >= $this->registration_start
            && $now <= $this->registration_end
            && $this->remaining_slots > 0;
    }

    /**
     * Verificar se há vagas disponíveis
     */
    public function hasAvailableSlots(): bool
    {
        return $this->remaining_slots > 0;
    }

    /**
     * Calcular percentual de ocupação
     */
    public function getOccupancyPercentageAttribute(): float
    {
        if ($this->max_students <= 0) return 0;

        $occupied = $this->max_students - $this->remaining_slots;
        return round(($occupied / $this->max_students) * 100, 2);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithAvailableSlots($query)
    {
        return $query->where('remaining_slots', '>', 0);
    }
}
