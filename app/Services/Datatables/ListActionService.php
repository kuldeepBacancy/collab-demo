<?php

namespace App\Services\Datatables;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class ListActionService
{
    public static function getEditAction()
    {
        return EditAction::make()
            ->label('');
    }

    public static function getDeleteAction()
    {
        return DeleteAction::make()
            ->label('');
    }
}
