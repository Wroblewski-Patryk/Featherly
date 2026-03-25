<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContentExportController extends Controller
{
    private const DEFAULT_PER_PAGE = 50;
    private const MAX_PER_PAGE = 100;

    /**
     * Export content records in a stable JSON envelope for external consumption.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:page,post,project'],
            'status' => ['nullable', 'in:draft,planned,published'],
            'locale' => ['nullable', 'string', 'size:2'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:' . self::MAX_PER_PAGE],
        ]);

        $type = (string) $validated['type'];
        $status = $validated['status'] ?? 'published';
        $locale = $validated['locale'] ?? app()->getLocale();
        $perPage = (int) ($validated['per_page'] ?? self::DEFAULT_PER_PAGE);

        $modelMap = [
            'page' => Page::class,
            'post' => Post::class,
            'project' => Project::class,
        ];
        $modelClass = $modelMap[$type];

        $paginator = $modelClass::query()
            ->where('status', $status)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $items = $paginator->getCollection()
            ->map(fn (Model $item): array => $this->mapItem($item, $type, $locale))
            ->values();

        return $this->jsonSuccess([
            'export' => [
                'type' => $type,
                'status' => $status,
                'locale' => $locale,
                'items' => $items,
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
                'links' => [
                    'next' => $paginator->nextPageUrl(),
                    'prev' => $paginator->previousPageUrl(),
                ],
            ],
        ]);
    }

    private function mapItem(Model $item, string $type, string $locale): array
    {
        /** @var mixed $titleRaw */
        $titleRaw = $item->getAttribute('title');
        /** @var mixed $slugRaw */
        $slugRaw = $item->getAttribute('slug');
        /** @var mixed $content */
        $content = $item->getAttribute('content');

        return [
            'id' => (int) $item->getAttribute('id'),
            'type' => $type,
            'status' => (string) $item->getAttribute('status'),
            'title' => $this->resolveLocalizedValue($titleRaw, $locale),
            'slug' => $this->resolveLocalizedValue($slugRaw, $locale),
            'content' => $content,
            'published_at' => optional($item->getAttribute('published_at'))->toIso8601String(),
            'updated_at' => optional($item->getAttribute('updated_at'))->toIso8601String(),
        ];
    }

    private function resolveLocalizedValue(mixed $value, string $locale): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        if (array_key_exists($locale, $value)) {
            return $value[$locale];
        }

        $fallbackLocale = config('app.fallback_locale');
        if (is_string($fallbackLocale) && array_key_exists($fallbackLocale, $value)) {
            return $value[$fallbackLocale];
        }

        foreach ($value as $candidate) {
            if (is_string($candidate) && trim($candidate) !== '') {
                return $candidate;
            }
        }

        return null;
    }
}
