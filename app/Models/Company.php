<?php

namespace App\Models;

use App\Enums\Common\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The database table that should be used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'status',
    ];

    /**
     * The attributes that should be hidden from array.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    /* Foreign Refs */
    public function vehicleModels(): HasMany
    {
        return $this->hasMany(VehicleModel::class)->status(Status::Active->value);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /* Scopes */
    public function scopeStatus($query, $where)
    {
        return $query->where('status', $where);
    }
}
