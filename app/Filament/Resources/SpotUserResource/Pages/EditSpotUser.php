<?php

namespace App\Filament\Resources\SpotUserResource\Pages;

use App\Filament\Resources\SpotUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpotUser extends EditRecord
{
    protected static string $resource = SpotUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getSubNavigation(): array
    {
        if(filled($cluster = static::getCluster())){
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
