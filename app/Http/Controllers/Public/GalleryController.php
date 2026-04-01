<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __invoke(Request $request)
    {
        $albums = Gallery::albums();
        $selectedAlbum = $request->input('album');

        $galleries = Gallery::query()
            ->when($selectedAlbum, fn ($q) => $q->byAlbum($selectedAlbum))
            ->ordered()
            ->paginate(12);

        return view('public.gallery', compact('galleries', 'albums', 'selectedAlbum'));
    }
}
