<?php

namespace App\Services\Datatables;

use App\Enums\Common\Status;
use Filament\Tables\Columns\TextColumn;

class ListService
{
    public static function getCompanyNameDisplay($column)
    {
        return TextColumn::make($column)
            ->label('Company')
            ->searchable();
    }

    public static function getVehicleModelDisplay($column)
    {
        return TextColumn::make($column)
            ->label('Vehicle Model')
            ->searchable();
    }

    public static function getStatusDisplay($column)
    {
        return TextColumn::make($column)
            ->badge()
            ->formatStateUsing(fn(Status $state): string => $state->getLabel())
            ->color(fn(Status $state): string => $state->getColor());
    }
}
