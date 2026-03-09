<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Template::query();

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                }
                );
            });

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        }
        else {
            $query->latest();
        }

        return Inertia::render('Admin/Templates/Index', [
            'templates' => $query->paginate(10)->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Templates/Edit', [
            'template' => new Template(),
            'templates' => [
                'header' => \App\Models\Template::where('type', 'header')->get(),
                'footer' => \App\Models\Template::where('type', 'footer')->get(),
                'sidebar' => \App\Models\Template::where('type', 'sidebar')->get(),
                'page' => \App\Models\Template::where('type', 'page')->get(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer,sidebar,page',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'content' => 'nullable|array',
            // SEO Fields
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'og_image' => 'nullable|string',
            'seo_index' => 'nullable|boolean',
            'seo_follow' => 'nullable|boolean',
        ]);

        // Map flat strings to arrays for JSON storage (consistent with Spatie models)
        foreach (['meta_title', 'meta_description', 'og_image'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = ['pl' => $data[$field]];
            }
        }

        $template = Template::create($data);
        return redirect()->route('admin.templates.edit', $template->id)->with('success', 'Template created successfully.');
    }

    public function edit(Template $template)
    {
        return Inertia::render('Admin/Templates/Edit', [
            'template' => $template->load('revisions'),
            'templates' => [
                'header' => \App\Models\Template::where('type', 'header')->get(),
                'footer' => \App\Models\Template::where('type', 'footer')->get(),
                'sidebar' => \App\Models\Template::where('type', 'sidebar')->get(),
                'page' => \App\Models\Template::where('type', 'page')->get(),
            ],
        ]);
    }

    public function update(Request $request, Template $template)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer,sidebar,page',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'content' => 'nullable|array',
            // SEO Fields
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'og_image' => 'nullable|string',
            'seo_index' => 'nullable|boolean',
            'seo_follow' => 'nullable|boolean',
        ]);

        // Store revision
        if ($template->content) {
            $template->revisions()->create([
                'content' => $template->content,
                'user_id' => auth()->id(),
            ]);
        }

        // Map flat strings to arrays for JSON storage (consistent with Spatie models)
        foreach (['meta_title', 'meta_description', 'og_image'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = ['pl' => $data[$field]];
            }
        }

        $template->update($data);
        return redirect()->back()->with('success', 'Template updated successfully.');
    }

    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->back()->with('message', 'Template deleted successfully');
    }
}
