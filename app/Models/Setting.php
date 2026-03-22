<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('global_settings');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('global_settings');
        });
    }
}
