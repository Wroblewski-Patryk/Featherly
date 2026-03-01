<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        return Inertia::render('Admin/Media/Index', [
            'media' => $media
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255']
        ]);

        $file = $request->file('file');
        $path = $file->store('media', 'public');

        Media::create([
            'path' => $path,
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $request->alt_text
        ]);

        return redirect()->back()->with('message', 'File uploaded successfully.');
    }

    public function destroy(Media $medium)
    {
        if (Storage::disk('public')->exists($medium->path)) {
            Storage::disk('public')->delete($medium->path);
        }
        $medium->delete();

        return redirect()->back()->with('message', 'File deleted successfully.');
    }
}
