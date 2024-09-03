<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Vehicle;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use App\Enums\Common\Status;
use App\Models\VehicleModel;
use Filament\Resources\Resource;
use App\Enums\Vehicle\VehicleType;
use App\Traits\Vehicle\FormFieldTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\VehicleResource\Pages;
use App\Filament\Resources\Admin\VehicleResource\RelationManagers;

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
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->required(),
                    ])
                    ->columnSpan(12),
                Forms\Components\Grid::make()
                    ->schema([
                        FormFieldTrait::getCompanySelectField(true),
                        FormFieldTrait::getVehicleModelField(true),
                    ])
                    ->columnSpan(12),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('vehicle_type')
                            ->label('Vehicle Type')
                            ->hint('Scooter contains "Bike" as well')
                            ->hintIcon('heroicon-m-information-circle')
                            ->options(VehicleType::class),
                        Forms\Components\TextInput::make('vehicle_number')
                            ->label('Vehicle Number')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(Status::class),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_model.model_name')
                    ->label('Vehicle Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_number')
                    ->label('Vehicle number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        Status::Active->name => 'success',
                        Status::Inactive->name => 'warning',
                    }),
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
                                FormFieldTrait::getCompanySelectField(false, true),
                                FormFieldTrait::getVehicleModelField(false, true),
                            ])
                            ->columnSpan(12),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            Arr::get($data, 'company_id'),
                            fn(Builder $query, $company_id): Builder => $query->whereIn('company_id', $company_id)
                        )
                            ->when(
                                Arr::get($data, 'vehicle_model_id'),
                                fn(Builder $query, $vehicle_model_id): Builder => $query->whereIn('vehicle_model_id', $vehicle_model_id)
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!Arr::hasNotNull($data, 'company_id') && !Arr::hasNotNull($data, 'vehicle_model_id')) {
                            return null;
                        } else {
                            $returnValue = "";
                            if (Arr::hasNotNull($data, 'company_id')) {
                                $companyList = Company::whereIn('id', Arr::get($data, 'company_id'))->pluck('company_name')->toArray();
                                $returnValue .= "Company: " . implode(", ", $companyList);
                            }

                            if (Arr::hasNotNull($data, 'vehicle_model_id')) {
                                $vehicleModelList = VehicleModel::whereIn('id', Arr::get($data, 'company_id'))->pluck('model_name')->toArray();
                                $returnValue .= " --- Vehicle Model: " . implode(", ", $vehicleModelList);
                            }

                            return $returnValue;
                        }
                    })
                    ->columnSpan(2),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(Status::class),
            ])
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
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
