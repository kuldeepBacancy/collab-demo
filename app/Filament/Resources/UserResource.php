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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Roles and Permissions';

    public static function form(Form $form): Form
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
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->required(),
                FileUpload::make('avatar_url')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg','image/png','image/jpg'])
                    ->disk('profile'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname'),
                TextColumn::make('lastname'),
                TextColumn::make('email'),
                TextColumn::make('roles.name'),
                TextColumn::make('phone_number'),
                ImageColumn::make('avatar_url')->disk('profile'),
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
