<?php

namespace App\Enums;

class UserType
{
    const ALUNO = 'aluno';
    const INSTRUTOR = 'instrutor';
    const ADMIN = 'admin';
    const USER = 'user'; // Compatibilidade com dados existentes

    public static function getValues(): array
    {
        return [
            self::ALUNO,
            self::INSTRUTOR,
            self::ADMIN,
            self::USER,
        ];
    }
}
