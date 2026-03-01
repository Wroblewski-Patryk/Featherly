<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(10);
        return Inertia::render('Admin/Templates/Index', [
            'templates' => $templates
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Templates/Edit', [
            'template' => new Template()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer',
            'is_active' => 'boolean',
            'content' => 'nullable|array'
        ]);

        $template = Template::create($data);
        return redirect()->route('admin.templates.edit', $template->id)->with('message', 'Template created successfully');
    }

    public function edit(Template $template)
    {
        return Inertia::render('Admin/Templates/Edit', [
            'template' => $template
        ]);
    }

    public function update(Request $request, Template $template)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer',
            'is_active' => 'boolean',
            'content' => 'nullable|array'
        ]);

        $template->update($data);
        return redirect()->back()->with('message', 'Template updated successfully');
    }

    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->back()->with('message', 'Template deleted successfully');
    }
}
