<?php

namespace App\Models;

use App\Enums\Common\Status;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database table that should be used by the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'vehicle_model_id',
        'vehicle_number',
        'vehicle_type',
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
        'vehicle_type' => VehicleType::class,
    ];


    /* Foreign Refs */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class)->status(Status::Active->value);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class)->status(Status::Active->value);
    }


    /* Scopes */
    public function scopeStatus($query, $where)
    {
        return $query->where('status', $where);
    }

    public function scopeVehicleType($query, $where)
    {
        return $query->where('vehicle_type', $where);
    }
}
