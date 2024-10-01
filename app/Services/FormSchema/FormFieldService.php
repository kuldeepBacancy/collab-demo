<?php

namespace App\Services\FormSchema;

use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Enums\Common\Status;
use App\Models\VehicleModel;
use Illuminate\Validation\Rule;
use App\Enums\Vehicle\VehicleType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;

class FormFieldService
{
    /* Common fields - start */
    /* Status field */
    public static function getStatusField()
    {
        return Select::make('status')
            ->label('Status')
            ->options(Status::class)
            ->default(Status::Active->value);
    }

    /* Common text field */
    public static function getTextField($column, $label = '', $maxLength = 0, $unique = false, $required = false)
    {
        $textField = TextInput::make($column)
            ->label($label);

        if ($maxLength != 0) {
            $textField->maxLength($maxLength)->rule(['max: ' . $maxLength]);
        }

        if ($unique) {
            $textField->unique(ignoreRecord: true);
        }

        if ($required) {
            $textField->required();
        }

        return $textField;
    }

    public static function getUserSelectField($column, $label, $relationShip, $required = false)
    {
        $selectField = Select::make($column)
            ->label($label)
            ->relationship(name: $relationShip, titleAttribute: 'name');

        if ($required) {
            $selectField->required();
        }

        return $selectField;
    }

    /* Common fields - end */

    /* Company select field */
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

    /* Vehicle model select field */
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
                self::getTextField('model_name', 'Vehicle Model', 100, true, true),
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


    /* Vehicle type field */
    public static function getVehicleTypeField()
    {
        return Select::make('vehicle_type')
            ->label('Vehicle Type')
            ->hint('Scooter contains "Bike" as well')
            ->hintIcon('heroicon-m-information-circle')
            ->options(VehicleType::class)
            ->default(VehicleType::Scooter->value);
    }
}
