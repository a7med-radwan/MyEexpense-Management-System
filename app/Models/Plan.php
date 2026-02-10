<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['user_id', 'month', 'plan_data'];

    protected $casts = [
        'plan_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
