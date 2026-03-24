<?php

namespace App\Models;

use App\Support\SharedInertiaCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Revision;

use Spatie\Translatable\HasTranslations;

class Template extends Model
{
    use HasFactory, HasTranslations, \App\Traits\HasContentFeatures;
    protected $fillable = ['title', 'type', 'is_active', 'is_default', 'is_system', 'content', 'meta_title', 'meta_description', 'canonical_url', 'og_image', 'seo_index', 'seo_follow'];

    public $translatable = ['title', 'content', 'meta_title', 'meta_description', 'og_image'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($template) {
            SharedInertiaCache::forgetHeaderFooter($template->id);
        });

        static::deleting(function ($template) {
            if ($template->is_system) {
                throw new \Exception('Cannot delete system template.');
            }
            SharedInertiaCache::forgetHeaderFooter($template->id);
        });
    }


    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'is_system' => 'boolean',
    ];

    const TYPE_HEADER = 'header';
    const TYPE_FOOTER = 'footer';
    const TYPE_SIDEBAR = 'sidebar';
    const TYPE_PAGE = 'page';

    public static function getTypes()
    {
        return [
            self::TYPE_HEADER,
            self::TYPE_FOOTER,
            self::TYPE_SIDEBAR,
            self::TYPE_PAGE,
        ];
    }
}
