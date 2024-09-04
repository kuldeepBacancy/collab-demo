<?php

namespace App\Services\Datatables;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

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
