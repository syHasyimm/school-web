<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $albums = Gallery::albums();

        $galleries = Gallery::query()
            ->when($request->album, fn ($q, $a) => $q->byAlbum($a))
            ->ordered()
            ->paginate(20);

        return view('admin.galleries.index', compact('galleries', 'albums'));
    }

    public function create()
    {
        $albums = Gallery::albums();
        return view('admin.galleries.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'album' => 'nullable|string|max:100',
            'order' => 'integer|min:0',
        ]);

        $validated['image_path'] = $this->imageService->upload($request->file('image'), 'galleries');

        unset($validated['image']);
        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function edit(Gallery $gallery)
    {
        $albums = Gallery::albums();
        return view('admin.galleries.edit', compact('gallery', 'albums'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'album' => 'nullable|string|max:100',
            'order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $this->imageService->delete($gallery->image_path);
            $validated['image_path'] = $this->imageService->upload($request->file('image'), 'galleries');
        }

        unset($validated['image']);
        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Data galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->imageService->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:galleries,id',
        ]);

        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan galeri berhasil diperbarui.']);
    }
}
