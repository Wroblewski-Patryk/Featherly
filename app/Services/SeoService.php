<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class SeoService
{
    protected array $settings;

    public function __construct()
    {
        try {
            $this->settings = Setting::pluck('value', 'key')->toArray();
        } catch (\Exception $e) {
            $this->settings = [];
        }
    }

    /**
     * Build the page title based on context.
     */
    public function getTitle(string $area = 'public', string $module = '', string $action = '', $entity = null, bool $isHome = false, string $parent = ''): string
    {
        $brand = $this->getSetting('site_name', config('app.name', 'Featherly'));
        $separator = $this->getSetting('title_separator', ' - ');
        $order = $this->getSetting('title_order', 'brand_first');

        if ($area === 'admin') {
            return $this->buildAdminTitle($brand, $separator, $module, $action, $entity);
        }

        return $this->buildPublicTitle($brand, $separator, $order, $entity, $module, $isHome, $parent);
    }

    /**
     * Mapping of internal module names to human-readable titles.
     */
    public function getModuleLabel(string $module): string
    {
        $module = strtolower($module);
        
        // Try group 'admin' first, keys 'menu.*' or 'modules.*'
        $keys = ["menu.{$module}", "modules.{$module}", "common.{$module}"];
        
        foreach ($keys as $key) {
            $translation = \App\Models\Translation::where('group', 'admin')
                ->where('key', $key)
                ->first();

            if ($translation) {
                return $translation->getTranslation('text', App::getLocale()) 
                    ?: $translation->getTranslation('text', config('app.fallback_locale', 'en'))
                    ?: Str::ucfirst($module);
            }
        }

        // Fallback to ucfirst
        return Str::ucfirst($module);
    }

    /**
     * Build title for Admin area.
     * Pattern: {EntityName} - {Action} - {ModuleTitle} - Admin Panel - {Brand}
     */
    protected function buildAdminTitle(string $brand, string $separator, string $module, string $action, $entity = null): string
    {
        $moduleLabel = $this->getModuleLabel($module);
        
        // If action is same as index, maybe skip it if it's too redundant
        $actionLabel = '';
        if ($action && !in_array(strtolower($action), ['index', 'list', 'show'])) {
            $actionLabel = $this->getModuleLabel($action);
        }

        $entityTitle = $entity ? $this->getEntityTitle($entity) : '';

        $parts = [];
        if ($entityTitle)
            $parts[] = $entityTitle;
        if ($actionLabel)
            $parts[] = $actionLabel;
        if ($moduleLabel)
            $parts[] = $moduleLabel;
            
        // Admin Panel label
        $parts[] = $this->getModuleLabel('admin_panel');
        $parts[] = $brand;

        return implode($separator, array_filter($parts));
    }

    /**
     * Build title for Public area.
     * Pattern: {PageTitle} - {Parent} - {Brand}
     */
    protected function buildPublicTitle(string $brand, string $separator, string $order, $entity, string $module = '', bool $isHome = false, string $parent = ''): string
    {
        $pageTitle = $this->getEntityTitle($entity) ?: $this->getModuleLabel($module) ?: 'Untitled';

        if ($isHome) {
            $includePageTitle = $this->getSetting('homepage_include_page_title', false);
            if (!$includePageTitle) {
                return $brand;
            }
        }

        $parts = [];
        if ($order === 'page_first') {
            $parts[] = $pageTitle;
            if ($parent)
                $parts[] = $parent;
            $parts[] = $brand;
        }
        else {
            $parts[] = $brand;
            if ($parent)
                $parts[] = $parent;
            $parts[] = $pageTitle;
        }

        return implode($separator, array_filter($parts));
    }

    /**
     * Get title from entity (meta_title -> title -> module fallback).
     */
    public function getEntityTitle($entity): ?string
    {
        if (!$entity)
            return null;

        $locale = App::getLocale();
        $fallback = config('app.fallback_locale', 'en');

        if (is_object($entity)) {
            // Priority: meta_title -> title
            $title = $entity->getTranslation('meta_title', $locale)
                ?: $entity->getTranslation('title', $locale);

            // Fallback to other locales if current is empty
            if (!$title || trim((string)$title) === '') {
                $title = $entity->getTranslation('meta_title', $fallback)
                    ?: $entity->getTranslation('title', $fallback);
            }

            // Final fallback to any translation or slug if still empty
            if (!$title || trim((string)$title) === '') {
                $translations = $entity->getTranslations('title');
                $title = !empty($translations) ? reset($translations) : null;
            }

            if (!$title || trim((string)$title) === '') {
                $title = $entity->slug ?? null;
            }

            return $title ? (string)$title : null;
        }

        if (is_array($entity)) {
            $title = $entity['meta_title'][$locale] ?? $entity['title'][$locale] ?? null;
            if (!$title || trim((string)$title) === '') {
                $title = $entity['meta_title'][$fallback] ?? $entity['title'][$fallback] ?? null;
            }
            return $title ? (string)$title : null;
        }

        return $entity ? (string)$entity : null;
    }

    /**
     * Get SEO metadata for public pages.
     */
    public function getMetaData($entity = null, string $parent = ''): array
    {
        $locale = App::getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $defaultDesc = $this->getSetting('default_meta_description', '');
        $defaultOgImage = $this->getSetting('default_og_image', '');

        $data = [
            'title' => $this->getEntityTitle($entity),
            'full_title' => $this->getTitle('public', '', '', $entity, false, $parent),
            'parent' => $parent,
            'description' => $defaultDesc,
            'og_image' => $defaultOgImage,
            'robots' => 'index, follow',
            'canonical' => null,
            'alternate_locales' => $this->getHreflangMap($entity),
        ];

        if ($entity && is_object($entity)) {
            $data['description'] = $entity->getTranslation('meta_description', $locale) ?: $data['description'];
            $data['og_image'] = $entity->getTranslation('og_image', $locale) ?: $data['og_image'];
            $data['canonical'] = $entity->canonical_url ?: $data['canonical'];

            $index = $entity->seo_index ?? true;
            $follow = $entity->seo_follow ?? true;
            $data['robots'] = ($index ? 'index' : 'noindex') . ', ' . ($follow ? 'follow' : 'nofollow');
        }

        return $data;
    }

    /**
     * Build hreflang alternate links map.
     */
    protected function getHreflangMap($entity): array
    {
        if (!$entity || !is_object($entity)) {
            return [];
        }

        $locales = $this->getActiveLocales();

        if (empty($locales)) {
            return [];
        }

        $map = [];

        foreach ($locales as $locale) {
            $segments = $this->resolveEntityPathSegmentsForLocale($entity, $locale);

            if ($segments === []) {
                continue;
            }

            $map[$locale] = $this->buildLocalizedUrl($locale, $segments);
        }

        $defaultLocale = $this->getDefaultActiveLocale($locales);
        if ($defaultLocale && isset($map[$defaultLocale])) {
            $map['x-default'] = $map[$defaultLocale];
        }

        return $map;
    }

    protected function resolveEntityPathSegmentsForLocale(object $entity, string $locale): array
    {
        $slug = $this->getEntitySlugForLocale($entity, $locale);

        if ($slug === null) {
            return [];
        }

        $segments = [];

        if ($entity instanceof Post) {
            $archiveSegment = $this->resolveArchiveSegmentForLocale('blog_page_id', 'blog', $locale);
            if ($archiveSegment !== '') {
                $segments[] = $archiveSegment;
            }
        }

        if ($entity instanceof Project) {
            $archiveSegment = $this->resolveArchiveSegmentForLocale('projects_page_id', 'projects', $locale);
            if ($archiveSegment !== '') {
                $segments[] = $archiveSegment;
            }
        }

        $segments[] = $slug;

        return $segments;
    }

    protected function getEntitySlugForLocale(object $entity, string $locale): ?string
    {
        if (!method_exists($entity, 'getTranslation')) {
            return null;
        }

        $fallback = config('app.fallback_locale', 'en');
        $slug = $entity->getTranslation('slug', $locale, false)
            ?: $entity->getTranslation('slug', $fallback, false);

        if (!is_string($slug) || trim($slug) === '') {
            return null;
        }

        return trim($slug, '/');
    }

    protected function resolveArchiveSegmentForLocale(string $settingKey, string $fallbackSegment, string $locale): string
    {
        $archiveId = (int) ($this->settings[$settingKey] ?? 0);

        if ($archiveId <= 0) {
            return $fallbackSegment;
        }

        $archivePage = Page::query()->select(['id', 'slug'])->find($archiveId);

        if (!$archivePage) {
            return $fallbackSegment;
        }

        $fallbackLocale = config('app.fallback_locale', 'en');
        $slug = $archivePage->getTranslation('slug', $locale, false)
            ?: $archivePage->getTranslation('slug', $fallbackLocale, false);

        if (!is_string($slug) || trim($slug) === '') {
            return $fallbackSegment;
        }

        return trim($slug, '/');
    }

    protected function getActiveLocales(): array
    {
        $locales = Language::query()
            ->where('is_active', true)
            ->pluck('code')
            ->filter()
            ->values()
            ->all();

        if ($locales !== []) {
            return $locales;
        }

        return array_values(array_unique(array_filter([
            App::getLocale(),
            config('app.fallback_locale', 'en'),
        ])));
    }

    protected function getDefaultActiveLocale(array $locales): ?string
    {
        $default = Language::query()
            ->where('is_active', true)
            ->where('is_default', true)
            ->value('code');

        if (is_string($default) && in_array($default, $locales, true)) {
            return $default;
        }

        return $locales[0] ?? null;
    }

    protected function buildLocalizedUrl(string $locale, array $segments): string
    {
        $path = implode('/', array_filter(array_map(function ($segment) {
            return trim((string) $segment, '/');
        }, $segments), fn ($segment) => $segment !== ''));

        return url("/{$locale}" . ($path !== '' ? "/{$path}" : ''));
    }

    /**
     * Helper to get localized setting.
     */
    protected function getSetting(string $key, $default = null)
    {
        $value = $this->settings[$key] ?? $default;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            }
        }

        if (is_array($value)) {
            return $value[App::getLocale()] ?? $value[config('app.fallback_locale', 'en')] ?? reset($value) ?? $default;
        }

        return $value;
    }
}
