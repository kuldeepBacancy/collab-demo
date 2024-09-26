<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;

class User extends Authenticatable implements HasName, HasAvatar
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'phone_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        return $this->name ?: 'Unknown User';
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return isset($this->attributes['avatar_url']) ? Storage::disk('profile')->url($this->attributes['avatar_url']) : null;
    }
}
