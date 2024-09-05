<?php

namespace App\Services\FormSchema;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Enums\Common\Status;
use App\Models\VehicleModel;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FormFieldService
{
    /* Status field */
    public static function getStatusField()
    {
        return Select::make('status')
            ->label('Status')
            ->options(Status::class)
            ->default(Status::Active->value);
    }

    /* Company fields - start */
    public static function getCompanyTextField()
    {
        return TextInput::make('company_name')
            ->label('Company Name')
            ->required();
    }

    public static function getCompanySelectField($column, $dependentField = false, $required = false, $multiple = false)
    {
        $selectField = Select::make($column)
            ->label('Company')
            ->relationship(name: 'company', titleAttribute: 'company_name');

        if ($dependentField) {
            $selectField->live()
                ->afterStateUpdated(fn(Set $set) => $set('vehicle_model_id', null));
        }

        if ($required) {
            $selectField->required();
        }

        if ($multiple) {
            $selectField->multiple();
        }
        return $selectField;
    }
    /* Company fields - end */

    /* Vehicle model fields - start */
    public static function getVehicleModelTextField()
    {
        return TextInput::make('model_name')
            ->label('Vehicle Model')
            ->required();
    }

    public static function getVehicleModelSelectField($column, $addOption = false, $required = false, $multiple = false)
    {
        $selectField = Select::make($column)
            ->label('Vehicle Model')
            ->relationship(name: 'vehicleModel', titleAttribute: 'model_name')
            ->options(function (Get $get) use ($multiple) {
                $vehicleModelList = VehicleModel::query()->status(Status::Active->value);
                if (!empty($get('company_id'))) {
                    if ($multiple) {
                        $vehicleModelList = $vehicleModelList->whereIn('company_id', $get('company_id'));
                    } else {
                        $vehicleModelList = $vehicleModelList->where('company_id', $get('company_id'));
                    }
                }
                return $vehicleModelList->pluck('model_name', 'id');
            })
            ->disabled(fn(Get $get) => !$get('company_id'));

        if ($addOption) {
            $selectField->createOptionForm([
                self::getCompanySelectField('company_id', false, true),
                self::getVehicleModelTextField(),
                self::getStatusField(),
            ])
                ->preload();
        }

        if ($required) {
            $selectField->required();
        }

        if ($multiple) {
            $selectField->multiple();
        }
        return $selectField;
    }
    /* Vehicle model fields - end */
}
