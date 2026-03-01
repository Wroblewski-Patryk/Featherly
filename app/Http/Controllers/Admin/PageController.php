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
        return Inertia::render('Admin/Pages/Edit', [
            'page' => new Page(),
            'templates' => \App\Models\Template::all()
        ]);
    }

    public function edit(Page $page)
    {
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page,
            'templates' => \App\Models\Template::all()
        ]);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('message', 'Page deleted successfully');
    }
}
