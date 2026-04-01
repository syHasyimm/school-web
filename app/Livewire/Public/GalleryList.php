<?php

namespace App\Livewire\Public;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryList extends Component
{
    use WithPagination;

    public $album = '';

    protected $queryString = [
        'album' => ['except' => ''],
    ];

    public function setAlbum($albumName)
    {
        $this->album = $albumName;
        $this->resetPage();
    }

    public function updatingAlbum()
    {
        $this->resetPage();
    }

    public function render()
    {
        $albums = Gallery::albums();

        $galleries = Gallery::query()
            ->when($this->album, fn ($q) => $q->byAlbum($this->album))
            ->ordered()
            ->paginate(12);

        return view('livewire.public.gallery-list', [
            'galleries' => $galleries,
            'albums' => $albums,
        ])->extends('layouts.app')->section('content');
    }
}
