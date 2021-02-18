<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Otp extends Model
{

    protected $fillable = [
        'user_id',
        'otp',
        'is_active'
        ];

    public function getHasExpiredAttribute()
    {
        return (carbon()->now()->diffInMinutes($this->created_at) > 5);
    }
}