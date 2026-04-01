<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->input('category');
        $search = $request->input('search');

        $posts = Post::published()
            ->with('author', 'categories')
            ->when($search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($selectedCategory, function ($q) use ($selectedCategory) {
                $q->whereHas('categories', fn ($c) => $c->where('slug', $selectedCategory));
            })
            ->latest('published_at')
            ->paginate(10);

        return view('public.posts.index', compact('posts', 'categories', 'selectedCategory', 'search'));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('author', 'categories')
            ->firstOrFail();

        $post->incrementViews();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function ($q) use ($post) {
                $q->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->with('author', 'categories')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.posts.show', compact('post', 'relatedPosts'));
    }
}
