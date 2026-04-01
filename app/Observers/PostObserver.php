<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Post;
use App\Services\ImageService;

class PostObserver
{
    public function __construct(protected ImageService $imageService) {}

    public function updating(Post $post): void
    {
        if ($post->isDirty('is_published') && $post->is_published && !$post->published_at) {
            $post->published_at = now();
        }
    }

    public function created(Post $post): void
    {
        ActivityLog::log('post_created', "Berita '{$post->title}' dibuat.", $post);
    }

    public function updated(Post $post): void
    {
        $changes = $post->getChanges();
        unset($changes['updated_at']);

        if (!empty($changes)) {
            ActivityLog::log('post_updated', "Berita '{$post->title}' diperbarui.", $post);
        }
    }

    public function deleting(Post $post): void
    {
        $this->imageService->delete($post->image_path);
    }

    public function deleted(Post $post): void
    {
        ActivityLog::log('post_deleted', "Berita '{$post->title}' dihapus.", $post);
    }
}
