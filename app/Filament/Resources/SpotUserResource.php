<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\SpotsManagement;
use App\Filament\Resources\SpotUserResource\Pages;
use App\Filament\Resources\SpotUserResource\RelationManagers;
use App\Models\Spot;
use App\Models\SpotUser;
use App\Rules\UniqueSpotForUser;
use App\Services\Datatables\ListActionService;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\ValidationException;

class SpotUserResource extends Resource
{
    protected static ?string $model = SpotUser::class;
    protected static ?string $cluster = SpotsManagement::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Assign Spot';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->required()
                    ->relationship('user', 'name',
                        modifyQueryUsing: fn (Builder $query) =>
                            $query->leftJoin('vehicles', 'users.id', '=', 'vehicles.user_id')
                                ->whereNotNull('vehicles.user_id')
                ),
                Select::make('spot_id')
                    ->label('Spot')
                    ->required()
                    ->hint('Only unoccupied spots are included')
                    ->hintIcon('heroicon-m-information-circle')
                    ->relationship('spot', 'name',
                        modifyQueryUsing: fn (Builder $query) =>
                            $query->leftJoin('spot_users', 'spots.id', '=', 'spot_users.spot_id')
                                ->whereNull('spot_users.spot_id')
                    )
                    ->rule(static function (Forms\Get $get, Forms\Components\Component $component): Closure {
                        return static function (string $attribute, $value, Closure $fail) use ($get, $component) {
                            $userId = $get('user_id');
                            if (!$userId) {
                                return;
                            }
                            $existingSpots = SpotUser::with('spot')
                                ->where('user_id', $userId)
                                ->get();
                            $carSpots = $existingSpots->filter(fn($spotUser) => $spotUser->spot->vehicle_type->value == 1)->count();
                            $scooterSpots = $existingSpots->filter(fn($spotUser) => $spotUser->spot->vehicle_type->value == 0)->count();
                            $newSpotType = Spot::find($value)?->vehicle_type;
                            if ($newSpotType == null) {
                                $fail('The selected spot does not exist.'); // Spot does not exist
                            }
                            if ($carSpots >= 1 && $newSpotType->value == 1) {
                                $fail('User already has a Car spot.'); // User already has a Car spot
                            }
                            if ($scooterSpots >= 1 && $newSpotType->value == 0) {
                                $fail('User already has a Scooter spot.'); // User already has a Scooter spot
                            }
                            if ($carSpots >= 1 && $scooterSpots >= 1) {
                                $fail('User has both types of spots.'); // User has both types
                            }
                        };
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('spot.name')
            ])
            ->filters([
                //
            ])
            ->actions([
                ListActionService::getDeleteAction()
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
            'index' => Pages\ListSpotUsers::route('/'),
            'create' => Pages\CreateSpotUser::route('/create'),
            // 'edit' => Pages\EditSpotUser::route('/{record}/edit'),
        ];
    }
}
