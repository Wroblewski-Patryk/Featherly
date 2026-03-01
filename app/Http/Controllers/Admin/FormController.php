<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    public function index(Request $request)
    {
        $query = Form::query();

        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%");
        });

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        }
        else {
            $query->latest();
        }

        return Inertia::render('Admin/Forms/Index', [
            'forms' => $query->paginate(10)->withQueryString()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Forms/Edit', [
            'formModel' => new Form(),
            'menus' => \App\Models\Menu::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        Form::create($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Form created successfully.');
    }

    public function edit(Form $form)
    {
        return Inertia::render('Admin/Forms/Edit', [
            'formModel' => $form,
            'menus' => \App\Models\Menu::all()
        ]);
    }

    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        $form->update($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Form updated successfully.');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted successfully.');
    }
}
