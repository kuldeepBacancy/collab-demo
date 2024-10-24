<?php

namespace App\Filament\Resources\CompanyResource\Widgets;

use App\Enums\Common\Status;
use App\Models\Company;
use Filament\Widgets\Widget;

class CompanyCountWidget extends Widget
{
    protected static string $view = 'filament.resources.admin.company-resource.widgets.company-count-widget';

    protected int|string|array $columnSpan = 1;

    protected static ?int $pollingInterval = 30;

    protected function getViewData(): array
    {
        return [
            'totalCompanys' => Company::query()->where('status', Status::Active->value)->count(),
        ];
    }
}
