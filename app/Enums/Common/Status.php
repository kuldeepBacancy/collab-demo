<?php

namespace App\Enums\Common;

enum Status: int
{
    case Active = 1;

    case Inactive = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'warning',
        };
    }
}
