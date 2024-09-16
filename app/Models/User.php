<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasName
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'firstname',
        'lastname',
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
        return $this->firstname . ' ' . $this->lastname ?: 'Unknown User';
    }

    public function getAvatarUrlAttribute(): string
    {
        $user = auth()->user();
        return asset('storage/admin/profile_photos/' . $user['avatar_url']);
    }
}
