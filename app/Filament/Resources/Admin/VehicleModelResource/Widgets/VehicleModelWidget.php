<?php

namespace App\Filament\Resources\Admin\VehicleModelResource\Widgets;

use App\Enums\Common\Status;
use App\Models\VehicleModel;
use Filament\Widgets\Widget;

class VehicleModelWidget extends Widget
{
    protected static string $view = 'filament.resources.admin.vehicle-model-resource.widgets.vehicle-model-widget';

    protected int | string | array $columnSpan = 1;

    protected static ?int $pollingInterval = 30;

    protected function getViewData(): array
    {
        return [
            'totalVehicleModels' => VehicleModel::query()->status(Status::Active->name)->count(),
            // Add any other data you want to pass to the view
        ];
    }
}
