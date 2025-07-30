<?php

namespace App\Enums;

class UserStatus
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const SUSPENDED = 'suspended';
    const PENDING = 'pending';

    public static function getValues(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::SUSPENDED,
            self::PENDING,
        ];
    }
}
