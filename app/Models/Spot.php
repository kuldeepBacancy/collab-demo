<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Vehicle\VehicleType;

class Spot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_type'
    ];

    protected $casts = [
        'vehicle_type' => VehicleType::class,
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($spot) {
            $spot->spotUser()->delete();
        });
    }

    public function spotUser(){
        return $this->hasOne(SpotUser::class);
    }
}
