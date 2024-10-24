<?php

namespace App\Filament\Resources\SpotUserResource\Pages;

use App\Filament\Resources\SpotUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpotUsers extends ListRecords
{
    protected static string $resource = SpotUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Spot')
            ,
        ];
    }

    public function canEdit()
    {
        return false;
    }
}
