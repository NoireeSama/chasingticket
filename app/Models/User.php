<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'phone', 'password', 'role', 'google_id', 'avatar_path', 'description'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function merchantReviews()
    {
        return $this->hasManyThrough(Review::class, Event::class, 'user_id', 'event_id');
    }

    public function getMerchantRatingAttribute()
    {
        return round($this->merchantReviews()->avg('rating') ?? 0, 1);
    }

    public function getMerchantReviewsCountAttribute()
    {
        return $this->merchantReviews()->count();
    }
}
