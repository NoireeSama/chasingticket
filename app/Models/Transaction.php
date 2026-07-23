<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'event_id', 'order_id', 'customer_name', 'customer_email', 'customer_phone',
        'total_price', 'status', 'snap_token', 'quantity', 'attendees',
        'coupons_used', 'discount_amount'
    ];

    protected $casts = [
        'total_price' => 'integer',
        'quantity' => 'integer',
        'attendees' => 'array',
        'coupons_used' => 'array',
        'discount_amount' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
