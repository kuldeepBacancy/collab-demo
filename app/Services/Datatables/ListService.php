<?php

namespace App\Services\Datatables;

use App\Enums\Common\Status;
use Filament\Tables\Columns\TextColumn;

class ListService
{
    /* Common text field */
    public static function getCommonTextColumn($column, $label)
    {
        return TextColumn::make($column)
            ->label($label)
            ->searchable();
    }

    /* Common select field */
    public static function getStatusDisplay($column)
    {
        return TextColumn::make($column)
            ->badge()
            ->formatStateUsing(fn (Status $state): string => $state->getLabel())
            ->color(fn (Status $state): string => $state->getColor());
    }
}
