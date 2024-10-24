<?php

namespace App\Filament\Resources\SpotResource\Pages;

use App\Filament\Resources\SpotResource;
use App\Models\Spot;
use App\Models\SpotUser;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateSpot extends CreateRecord
{
    protected static string $resource = SpotResource::class;

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
