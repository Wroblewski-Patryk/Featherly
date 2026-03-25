<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function blocks()
    {
        return Inertia::render('Admin/Blocks');
    }

    public function publicationCalendar()
    {
        $locale = app()->getLocale();

        $scheduledItems = collect()
            ->merge($this->scheduledItems(Page::query(), 'page', 'admin.pages.edit', $locale))
            ->merge($this->scheduledItems(Post::query(), 'post', 'admin.posts.edit', $locale))
            ->merge($this->scheduledItems(Project::query(), 'project', 'admin.projects.edit', $locale))
            ->sortBy('published_at')
            ->values();

        $calendarDays = $scheduledItems
            ->groupBy(fn (array $item): string => substr($item['published_at'], 0, 10))
            ->map(fn (Collection $items, string $date): array => [
                'date' => $date,
                'count' => $items->count(),
                'items' => $items->values()->all(),
            ])
            ->values();

        return Inertia::render('Admin/PublicationCalendar', [
            'calendar_days' => $calendarDays,
            'totals' => [
                'items' => $scheduledItems->count(),
                'days' => $calendarDays->count(),
                'types' => $scheduledItems->countBy('type')->toArray(),
            ],
        ]);
    }

    private function scheduledItems(Builder $query, string $type, string $editRoute, string $locale): Collection
    {
        return $query
            ->where('status', 'planned')
            ->whereNotNull('published_at')
            ->orderBy('published_at')
            ->get(['id', 'title', 'status', 'published_at'])
            ->map(function ($item) use ($type, $editRoute, $locale): array {
                $publishedAt = $item->getAttribute('published_at');
                $id = (int) $item->getAttribute('id');
                $title = $item->getAttribute('title');
                $status = (string) $item->getAttribute('status');

                if (!$publishedAt instanceof CarbonInterface) {
                    return [];
                }

                return [
                    'id' => $id,
                    'type' => $type,
                    'title' => $this->resolveLocalizedTitle($title, $locale, $type, $id),
                    'status' => $status,
                    'published_at' => $publishedAt->toIso8601String(),
                    'published_at_label' => $publishedAt->format('Y-m-d H:i'),
                    'edit_url' => route($editRoute, $item),
                ];
            })
            ->filter()
            ->values();
    }

    private function resolveLocalizedTitle(mixed $rawTitle, string $locale, string $type, int $id): string
    {
        if (is_string($rawTitle) && trim($rawTitle) !== '') {
            return $rawTitle;
        }

        if (is_array($rawTitle)) {
            $localized = $rawTitle[$locale] ?? null;

            if (is_string($localized) && trim($localized) !== '') {
                return $localized;
            }

            foreach ($rawTitle as $value) {
                if (is_string($value) && trim($value) !== '') {
                    return $value;
                }
            }
        }

        return ucfirst($type) . ' #' . $id;
    }
}
