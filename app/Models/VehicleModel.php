<?php

namespace App\Models;

use App\Enums\Common\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database table that should be used by the model.
     *
     * @var string
     */
    protected $table = 'vehicle_models';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'model_name',
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
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class)->status(Status::Active->value);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class)->status(Status::Active->value);
    }


    /* Scopes */
    public function scopeStatus($query, $where)
    {
        return $query->where('status', $where);
    }
}
