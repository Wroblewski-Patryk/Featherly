<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'slug', 'meta_title', 'meta_description', 'og_image'];

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
    ];
    public function headerOverride()
    {
        return $this->belongsTo(Template::class , 'header_override_id');
    }

    public function footerOverride()
    {
        return $this->belongsTo(Template::class , 'footer_override_id');
    }
}
