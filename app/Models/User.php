<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'type' => UserType::class,
        ];
    }

    /**
     * Atributos com valores padrão.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'aluno',
        'status' => 'active',
    ];

    /**
     * Relacionamento com Student (um-para-um)
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Verificar se o usuário é um admin.
     */
    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN || $this->type->value === 'admin';
    }

    /**
     * Verificar se o usuário é um aluno.
     */
    public function isAluno(): bool
    {
        return $this->type === UserType::ALUNO || $this->type->value === 'aluno';
    }

    /**
     * Verificar se o usuário é um instrutor.
     */
    public function isInstrutor(): bool
    {
        return $this->type === UserType::INSTRUTOR || $this->type->value === 'instrutor';
    }

    /**
     * Verificar se o usuário está ativo.
     */
    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE || $this->status->value === 'active';
    }

    /**
     * Obter ou criar perfil de estudante
     */
    public function getOrCreateStudentProfile(): Student
    {
        if (!$this->student) {
            return $this->student()->create([
                'name' => $this->name,
                'email' => $this->email,
                'interests' => ['Desenvolvimento Web'], // Interesse padrão
            ]);
        }

        return $this->student;
    }
}
