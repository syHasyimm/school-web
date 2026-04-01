<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setCategory($slug)
    {
        $this->category = $slug;
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::all();

        $posts = Post::published()
            ->with('author', 'categories')
            ->when($this->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($this->category, function ($q) {
                $q->whereHas('categories', fn ($c) => $c->where('slug', $this->category));
            })
            ->latest('published_at')
            ->paginate(10);

        return view('livewire.public.post-list', [
            'posts' => $posts,
            'categories' => $categories,
        ])->extends('layouts.app')->section('content');
    }
}
