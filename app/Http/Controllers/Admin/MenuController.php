<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%");
        });

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        }
        else {
            $query->latest();
        }

        return Inertia::render('Admin/Menus/Index', [
            'menus' => $query->paginate(10)->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Menus/Edit', [
            'menu' => new Menu(['items' => []]),
            'pages' => \App\Models\Page::select('id', 'title')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'nullable|array',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        return Inertia::render('Admin/Menus/Edit', [
            'menu' => $menu,
            'pages' => \App\Models\Page::select('id', 'title')->get()
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'nullable|array',
        ]);

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
