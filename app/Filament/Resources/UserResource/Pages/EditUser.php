<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Jobs\SendEmailForPasswordChangeJob;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected $password;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $oldPath = $this->record->avatar_url;

        if (isset($data['password']) && $data['password']) {
            $this->password = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        // if (isset($data['avatar_url']) && $data['avatar_url']) {
        //     Storage::disk('profile')->delete($oldPath);
        // }

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->password) {
            $name = $this->record->firstname . ' ' . $this->record->lastname;
            $email = $this->record->email;
            $password = $this->password;

            SendEmailForPasswordChangeJob::dispatch($name, $email, $password);
        }
    }
}
