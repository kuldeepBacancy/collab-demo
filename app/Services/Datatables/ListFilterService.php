<?php

namespace App\Services\Datatables;

use App\Enums\Common\Status;
use Filament\Tables\Filters\SelectFilter;

class ListFilterService
{
    public static function getStatusFilter()
    {
        return SelectFilter::make('status')
            ->label('Status')
            ->options(Status::class);
    }

    public static function getCompanyFilter($column)
    {
        return SelectFilter::make($column)
            ->label('Company')
            ->relationship('company', 'company_name')
            ->multiple();
    }
}
