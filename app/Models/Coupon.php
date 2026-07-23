<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'user_id', 'code', 'type', 'value', 'expires_at', 'is_limited', 'limit_count', 'used_count'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'value' => 'integer',
        'expires_at' => 'datetime',
        'is_limited' => 'boolean',
        'limit_count' => 'integer',
        'used_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
