<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int|string|array
    {
        return 3;
    }
}
