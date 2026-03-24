<?php

namespace App\Support;

use App\Models\Language;
use App\Models\Template;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SharedInertiaCache
{
    public static function forgetSettings(): void
    {
        Cache::forget('global_settings');
    }

    public static function forgetHeaderFooter(?int $templateId = null): void
    {
        Cache::forget('global_header_default');
        Cache::forget('global_footer_default');

        if ($templateId) {
            Cache::forget('global_header_' . $templateId);
            Cache::forget('global_footer_' . $templateId);
        }
    }

    public static function forgetAllHeaderFooterVariants(): void
    {
        self::forgetHeaderFooter();
        Template::query()->pluck('id')->each(function ($id) {
            Cache::forget('global_header_' . $id);
            Cache::forget('global_footer_' . $id);
        });
    }

    public static function forgetLanguages(): void
    {
        Cache::forget('active_languages');
    }

    public static function forgetProjects(): void
    {
        Cache::forget('all_projects');
    }

    public static function forgetTranslationsForActiveLocales(): void
    {
        try {
            $locales = Language::query()->where('is_active', true)->pluck('code')->all();
            foreach ($locales as $locale) {
                Cache::forget('translations.' . $locale);
            }
        } catch (\Throwable $e) {
            Log::warning('Could not clear translation cache: ' . $e->getMessage());
        }
    }

    public static function forgetSettingsAndTemplateDrivenSharedData(): void
    {
        self::forgetSettings();
        self::forgetAllHeaderFooterVariants();
    }
}
