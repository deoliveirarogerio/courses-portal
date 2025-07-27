<?php

namespace App\Enums;

enum UserType: string
{
    case ALUNO = 'aluno';
    case INSTRUTOR = 'instrutor';
    case ADMIN = 'admin';
    case USER = 'user'; // Compatibilidade com dados existentes

    public function label(): string
    {
        return match($this) {
            self::ALUNO => 'Aluno',
            self::INSTRUTOR => 'Instrutor',
            self::ADMIN => 'Administrador',
            self::USER => 'Usuário',
        };
    }

    public static function getValues(): array
    {
        return [
            self::ALUNO->value,
            self::INSTRUTOR->value,
            self::ADMIN->value,
            self::USER->value,
        ];
    }
}
