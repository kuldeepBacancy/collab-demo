<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Jobs\SendEmailForNewUserJob;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected $password;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->password = $data['password'];
        $data['password'] = Hash::make($data['password']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $name = $this->record->firstname.' '.$this->record->lastname;
        $email = $this->record->email;
        $password = $this->password;

        SendEmailForNewUserJob::dispatch($name, $email, $password);
    }
}
