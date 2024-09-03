<?php

namespace App\Traits\Vehicle;

use Filament\Forms;
use App\Models\VehicleModel;

trait FormFieldTrait
{
    public static function getCompanySelectField($required = false, $multiple = false)
    {
        $selectField = Forms\Components\Select::make('company_id')
            ->label('Company')
            ->relationship(name: 'company', titleAttribute: 'company_name')
            ->live()
            ->afterStateUpdated(fn(Forms\Set $set) => $set('vehicle_model_id', null));

        if ($required) {
            $selectField->required();
        }

        if ($multiple) {
            $selectField->multiple();
        }
        return $selectField;
    }

    public static function getVehicleModelField($required = false, $multiple = false)
    {
        $selectField = Forms\Components\Select::make('vehicle_model_id')
            ->label('Vehicle Model')
            ->options(function (Forms\Get $get) use ($multiple) {
                $vehicleModelList = VehicleModel::query()->status('Active');
                if (!empty($get('company_id'))) {
                    if ($multiple) {
                        $vehicleModelList = $vehicleModelList->whereIn('company_id', $get('company_id'));
                    } else {
                        $vehicleModelList = $vehicleModelList->where('company_id', $get('company_id'));
                    }
                }
                return $vehicleModelList->pluck('model_name', 'id');
            })
            ->disabled(fn(Forms\Get $get) => !$get('company_id'));

        if ($required) {
            $selectField->required();
        }

        if ($multiple) {
            $selectField->multiple();
        }
        return $selectField;
    }
}
