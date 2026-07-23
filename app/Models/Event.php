<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'title', 'description', 'date',
        'location', 'price', 'is_dynamic_pricing', 'dynamic_pricing_rules', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_dynamic_pricing' => 'boolean',
        'dynamic_pricing_rules' => 'array',
    ];

    public function getCurrentPriceAttribute()
    {
        if (!$this->is_dynamic_pricing || empty($this->dynamic_pricing_rules)) {
            return $this->price;
        }

        $currentPrice = $this->price;
        $now = now();

        foreach ($this->dynamic_pricing_rules as $rule) {
            if (!empty($rule['date']) && !empty($rule['price'])) {
                $ruleDate = \Carbon\Carbon::parse($rule['date']);
                if ($ruleDate->isPast() || $ruleDate->isCurrentSecond()) {
                    if (intval($rule['price']) > $currentPrice) {
                        $currentPrice = intval($rule['price']);
                    }
                }
            }
        }

        return $currentPrice;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
