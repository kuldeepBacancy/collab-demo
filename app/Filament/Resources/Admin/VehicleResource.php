<?php

namespace App\Filament\Resources\Admin;

use App\Enums\Vehicle\VehicleType;
use App\Filament\Resources\Admin\VehicleResource\Pages;
use App\Models\Company;
use App\Models\Vehicle;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationGroup = 'Vehicles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getUserSelectField('user_id', 'User', 'user', true),
                    ])
                    ->columnSpan(12),
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getCompanySelectField('company_id', true, true),
                        FormFieldService::getVehicleModelSelectField('vehicle_model_id', true, true),
                    ])
                    ->columnSpan(12),
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldService::getVehicleTypeField(),
                        FormFieldService::getTextField('vehicle_number', 'Vehicle Number', 20, true, true),
                        FormFieldService::getStatusField(),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ListService::getCommonTextColumn('user.name', 'User'),
                ListService::getCommonTextColumn('company.company_name', 'Company'),
                ListService::getCommonTextColumn('vehicleModel.model_name', 'Vehicle Model'),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->formatStateUsing(fn (VehicleType $state): string => $state->getLabel())
                    ->searchable(),
                ListService::getCommonTextColumn('vehicle_number', 'Vehicle Number'),
                ListService::getStatusDisplay('status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->multiple(),
                Tables\Filters\SelectFilter::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->options(VehicleType::class),
                Tables\Filters\Filter::make('company_model_filter')
                    ->form([
                        Forms\Components\Grid::make()
                            ->schema([
                                FormFieldService::getCompanySelectField('company_id', true, false, true),
                                FormFieldService::getVehicleModelSelectField('vehicle_model_id', false, false, true),
                            ])
                            ->columnSpan(12),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            Arr::get($data, 'company_id'),
                            fn (Builder $query, $company_id): Builder => $query->whereIn('company_id', $company_id)
                        )
                            ->when(
                                Arr::get($data, 'vehicle_model_id'),
                                fn (Builder $query, $vehicle_model_id): Builder => $query->whereIn('vehicle_model_id', $vehicle_model_id)
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! Arr::hasNotNull($data, 'company_id') && ! Arr::hasNotNull($data, 'vehicle_model_id')) {
                            return null;
                        } else {
                            $returnValue = '';
                            if (Arr::hasNotNull($data, 'company_id')) {
                                $companyList = Company::whereIn('id', Arr::get($data, 'company_id'))->pluck('company_name')->toArray();
                                $returnValue .= 'Company: '.implode(', ', $companyList);
                            }

                            if (Arr::hasNotNull($data, 'vehicle_model_id')) {
                                $vehicleModelList = VehicleModel::whereIn('id', Arr::get($data, 'company_id'))->pluck('model_name')->toArray();
                                $returnValue .= ' --- Vehicle Model: '.implode(', ', $vehicleModelList);
                            }

                            return $returnValue;
                        }
                    })
                    ->columnSpan(2),
                ListFilterService::getStatusFilter(),
            ])
            ->filtersFormColumns(2)
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
