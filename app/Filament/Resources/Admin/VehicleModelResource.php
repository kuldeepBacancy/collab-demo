<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\VehicleModelResource\Pages;
use App\Models\VehicleModel;
use App\Services\Datatables\ListActionService;
use App\Services\Datatables\ListFilterService;
use App\Services\Datatables\ListService;
use App\Services\FormSchema\FormFieldService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleModelResource extends Resource
{
    protected static ?string $model = VehicleModel::class;

    protected static ?string $navigationGroup = 'Vehicles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getCompanySelectField('company_id'),
                        FormFieldService::getTextField('model_name', 'Vehicle Model', 100, true, true),
                        FormFieldService::getStatusField(),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ListService::getCommonTextColumn('company.company_name', 'Company'),
                ListService::getCommonTextColumn('model_name', 'Vehicle Model'),
                ListService::getStatusDisplay('status'),
            ])
            ->filters([
                ListFilterService::getCompanyFilter('company_id'),
                ListFilterService::getStatusFilter(),
            ])
            ->actions([
                ListActionService::getEditAction(),
                ListActionService::getDeleteAction(),
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
            'index' => Pages\ListVehicleModels::route('/'),
            'create' => Pages\CreateVehicleModel::route('/create'),
            'edit' => Pages\EditVehicleModel::route('/{record}/edit'),
        ];
    }
}
