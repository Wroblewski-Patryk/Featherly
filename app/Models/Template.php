<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Revision;

class Template extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function revisions(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Revision::class , 'revisionable')->latest();
    }

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
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
