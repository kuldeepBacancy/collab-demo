<?php

namespace App\Filament\Pages\Auth;

use Doctrine\DBAL\Schema\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Ramsey\Uuid\Uuid;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->label('First name')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('lastname')
                            ->label('Last name')
                            ->required()
                            ->maxLength(50),
                        $this->getEmailFormComponent(),
                        TextInput::make('phone_number')
                            ->maxLength(20),
                        FileUpload::make('avatar_url')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg','image/png','image/jpg'])
                            ->maxSize(10240)
                            ->disk('profile')
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                return Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();
                            }),
                        $this->getPasswordFormComponent(),
                    ])
            ]);
    }
}
