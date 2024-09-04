<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\VehicleModel;
use Filament\Resources\Resource;
use App\Services\Datatables\ListService;
use Illuminate\Database\Eloquent\Builder;
use App\Services\FormSchema\FormFieldService;
use App\Services\Datatables\ListActionService;
use App\Services\Datatables\ListFilterService;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Factories\Relationship;
use App\Filament\Resources\Admin\VehicleModelResource\Pages;
use App\Filament\Resources\Admin\VehicleModelResource\RelationManagers;

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
                        FormFieldService::getVehicleModelTextField(),
                        FormFieldService::getStatusField(),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ListService::getCompanyNameDisplay('company.company_name'),
                ListService::getVehicleModelDisplay('model_name'),
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
