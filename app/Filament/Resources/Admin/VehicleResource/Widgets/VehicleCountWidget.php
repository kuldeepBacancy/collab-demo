<?php

namespace App\Filament\Resources\Admin\VehicleResource\Widgets;

use App\Enums\Common\Status;
use App\Models\Vehicle;
use Filament\Widgets\Widget;

class VehicleCountWidget extends Widget
{
    protected static string $view = 'filament.resources.admin.vehicle-resource.widgets.vehicle-count-widget';

    protected int|string|array $columnSpan = 1;

    protected static ?int $pollingInterval = 30;

    protected function getViewData(): array
    {
        return [
            'totalVehicles' => Vehicle::query()->status(Status::Active->name)->count(),
            // Add any other data you want to pass to the view
        ];
    }
}
