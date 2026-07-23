<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($activity)
    {
        self::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
        ]);
    }
}
