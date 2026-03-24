<?php

namespace App\Models;

use App\Support\SharedInertiaCache;
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
            SharedInertiaCache::forgetSettingsAndTemplateDrivenSharedData();
        });
        static::deleted(function () {
            SharedInertiaCache::forgetSettingsAndTemplateDrivenSharedData();
        });
    }
}
