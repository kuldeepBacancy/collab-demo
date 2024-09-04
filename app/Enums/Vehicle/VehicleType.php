<?php

namespace App\Enums\Vehicle;

enum VehicleType: int
{
    case Scooter = 0;

    case Car = 1;

    public function getLabel(): string
    {
        return match ($this) {
            self::Scooter => 'Scooter',
            self::Car => 'Car',
        };
    }
}
