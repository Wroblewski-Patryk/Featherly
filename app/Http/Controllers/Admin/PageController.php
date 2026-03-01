<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages
        ]);
    }

    public function create()
    {
        // Placeholder for the Block Builder
        return Inertia::render('Admin/Pages/Edit', [
            'page' => new Page()
        ]);
    }

    public function edit(Page $page)
    {
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page
        ]);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('message', 'Page deleted successfully');
    }
}
