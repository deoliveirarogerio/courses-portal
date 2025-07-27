<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case PENDING = 'pending';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Ativo',
            self::INACTIVE => 'Inativo',
            self::SUSPENDED => 'Suspenso',
            self::PENDING => 'Pendente',
        };
    }

    public static function getValues(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
            self::SUSPENDED->value,
            self::PENDING->value,
        ];
    }
}
