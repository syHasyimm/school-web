<?php

namespace App\Livewire\Public;

use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherList extends Component
{
    use WithPagination;

    public $position = '';

    protected $queryString = [
        'position' => ['except' => ''],
    ];

    public function setPosition($positionName)
    {
        $this->position = $positionName;
        $this->resetPage();
    }

    public function updatingPosition()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Get unique positions from active teachers
        $positions = Teacher::active()->select('position')->distinct()->pluck('position');

        $teachers = Teacher::active()
            ->when($this->position, fn ($q) => $q->where('position', $this->position))
            ->ordered()
            ->paginate(12);

        return view('livewire.public.teacher-list', [
            'teachers' => $teachers,
            'positions' => $positions,
        ])->extends('layouts.app')->section('content');
    }
}
