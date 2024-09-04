<?php

namespace App\Filament\Resources\Admin\CompanyResource\Widgets;

use App\Enums\Common\Status;
use App\Models\Company;
use Filament\Widgets\Widget;

class CompanyCountWidget extends Widget
{
    protected static string $view = 'filament.resources.admin.company-resource.widgets.company-count-widget';

    protected int | string | array $columnSpan = 1;

    protected static ?int $pollingInterval = 30;

    protected function getViewData(): array
    {
        return [
            'totalCompanys' => Company::query()->status(Status::Active->name)->count(),
            // Add any other data you want to pass to the view
        ];
    }
}
