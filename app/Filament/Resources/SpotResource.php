<?php

namespace App\Filament\Resources;

use App\Enums\Vehicle\VehicleType;
use App\Filament\Clusters\SpotsManagement;
use App\Filament\Resources\SpotResource\Pages;
use App\Filament\Resources\SpotResource\RelationManagers;
use App\Models\Spot;
use App\Models\SpotUser;
use App\Models\User;
use App\Services\Datatables\ListActionService;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Services\FormSchema\FormFieldService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class SpotResource extends Resource
{
    protected static ?string $model = Spot::class;
    protected static ?string $cluster = SpotsManagement::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->unique(ignoreRecord:true),
                FormFieldService::getVehicleTypeField()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->formatStateUsing(fn (VehicleType $state): string => $state->getLabel())
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ListActionService::getEditAction(),
                ListActionService::getDeleteAction()
                ->action(function ($record) {
                    $spotsCount = SpotUser::where('spot_id', $record->id)->count();
                    if ($spotsCount > 0) {
                        Notification::make()
                            ->title('Cannot delete this Spot')
                            ->body('There is existing user assigned to this spot. You cannot delete it.')
                            ->danger()
                            ->send();
                        return;
                    }
                    $record->delete();
                    Notification::make()
                        ->title('Spot Deleted')
                        ->body('The spot has been successfully deleted.')
                        ->success()
                        ->send();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpots::route('/'),
            'create' => Pages\CreateSpot::route('/create'),
            'edit' => Pages\EditSpot::route('/{record}/edit'),
        ];
    }
}
