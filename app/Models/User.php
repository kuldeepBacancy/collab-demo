<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasAvatar, HasName
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function spots(){
        return $this->belongsToMany(Spot::class);
    }

    public function getFilamentName(): string
    {
        return $this->name ?: 'Unknown User';
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return isset($this->attributes['profile_photo_path']) ? Storage::disk('profile')->url($this->attributes['profile_photo_path']) : null;
    }

    public function updateProfilePhoto(UploadedFile $photo)
    {
        $disk = $this->profilePhotoDisk();

        tap($this->profile_photo_path, function ($previous) use ($photo, $disk) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly('', ['disk' => $disk]),
            ])->save();

            if ($previous) {
                Storage::disk($disk)->delete($previous);
            }
        });
    }

    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? $_ENV['VAPOR_ARTIFACT_NAME'] : config('jetstream.profile_photo_disk', 'public');
    }
}
