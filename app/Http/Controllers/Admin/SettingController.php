<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $pages = Page::select('id', 'title', 'slug')->get();

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'pages' => $pages
        ]);
    }

    public function store(Request $request)
    {
        // Don't save internal inertia inertia props
        $data = $request->except(['_method', '_token']);
        $changedKeys = [];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            $changedKeys[] = $key;
        }

        AuditLogger::log('settings.updated', [
            'changed_keys' => $changedKeys,
            'changed_count' => count($changedKeys),
        ]);

        return redirect()->back()->with('success', 'settings.update_success');
    }
}
