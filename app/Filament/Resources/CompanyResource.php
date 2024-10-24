<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages\ListCompanies;
use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use App\Models\VehicleModel;
use App\Services\Datatables\ListActionService;
use App\Services\Datatables\ListFilterService;
use App\Services\Datatables\ListService;
use App\Services\FormSchema\FormFieldService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = 'Vehicles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getTextField('company_name', 'Company', 100, true, true),
                        FormFieldService::getStatusField(),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ListService::getCommonTextColumn('company_name', 'Company'),
                ListService::getStatusDisplay('status'),
            ])
            ->filters([
                ListFilterService::getStatusFilter(),
            ])
            ->actions([
                ListActionService::getEditAction(),
                ListActionService::getDeleteAction()
                ->action(function ($record) {
                    $vehicleModelsCount = VehicleModel::where('company_id', $record->id)->count();
                    if ($vehicleModelsCount > 0) {
                        Notification::make()
                            ->title('Cannot delete this company')
                            ->body('There are existing vehicle models for this company. You cannot delete it.')
                            ->danger()
                            ->send();
                        return;
                    }
                    $record->delete();
                    Notification::make()
                        ->title('Company Deleted')
                        ->body('The company has been successfully deleted.')
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function canDeleteCompany($record): bool
    {
        $vehicleModelsCount = VehicleModel::where('company_id', $record->id)->count();
        if ($vehicleModelsCount > 0) {
            return false; // Prevent deletion if vehicle models exist
        }

        return true; // Allow deletion if no vehicle models exist
    }
}
