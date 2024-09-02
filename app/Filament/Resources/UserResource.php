<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form, $record = null): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->required()
                    ->maxLength(50),
                TextInput::make('lastname')
                    ->required()
                    ->maxLength(50),
                TextInput::make('email')
                    ->required()
                    ->maxLength(100)
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->readOnlyOn(['edit']),
                TextInput::make('phone_number')
                    ->maxLength(20),
                // FileUpload::make('profile_picture')
                //     ->image()
                //     ->acceptedFileTypes(['image/jpeg','image/png','image/jpg'])
                //     ->maxSize(10240)
                //     ->disk('profile')
                //     ->directory(function () use ($record) {
                //         return 'profile_photos/' . ($record ? $record->id : 'temp');
                //     }),
                Select::make('roles')
                    ->relationship('roles', 'name')
            ]);
    }

    // protected static function afterSave($record)
    // {
    //     // Ensure the 'profile_picture' field is handled correctly
    //     if (request()->hasFile('profile_picture')) {
    //         $userId = $record->id; // Get the ID of the saved record
    //         $file = request()->file('profile_picture');
    //         $path = $file->store('profile_photos/' . $userId, 'profile');
    //         // Update the record with the file path
    //         $record->update([
    //             'profile_picture' => $path,
    //         ]);
    //     }
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname'),
                TextColumn::make('lastname'),
                TextColumn::make('email'),
                TextColumn::make('roles.name'),
                TextColumn::make('phone_number'),
                // ImageColumn::make('profile_picture'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
