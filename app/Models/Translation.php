<?php

namespace App\Models;

use App\Support\SharedInertiaCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Translation extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['group', 'key', 'text'];

    public $translatable = ['text'];

    protected static function booted()
    {
        static::saved(function () {
            static::clearTranslationCache();
        });

        static::deleted(function () {
            static::clearTranslationCache();
        });
    }

    protected static function clearTranslationCache()
    {
        SharedInertiaCache::forgetTranslationsForActiveLocales();
    }
}
