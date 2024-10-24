<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'spot_id',
        'user_id'
    ];

    public function spot(){
        return $this->belongsTo(Spot::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
