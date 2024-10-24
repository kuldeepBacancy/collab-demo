<?php

namespace App\Filament\Resources\SpotResource\Pages;

use App\Filament\Clusters\SpotsManagement;
use App\Filament\Resources\SpotResource;
use App\Models\SpotUser;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpot extends EditRecord
{
    protected static string $resource = SpotResource::class;

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
