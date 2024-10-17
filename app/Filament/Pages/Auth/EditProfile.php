<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
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
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(100),
                        $this->getEmailFormComponent()->readonly(),
                        TextInput::make('phone_number')
                            ->maxLength(20)
                            ->required(),
                        $this->getPasswordFormComponent(),
                        FileUpload::make('profile_photo_path')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(10240)
                            ->disk('profile')
                            ->label('Profile photo')
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                return Uuid::uuid4()->toString().'.'.$file->getClientOriginalExtension();
                            }),
                    ]),
            ]);
    }
}
