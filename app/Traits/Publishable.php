<?php

namespace App\Traits;

trait Publishable
{

    /**
     * Publish an existing resource.
     */
    public function publish()
    {
        return $this->update([
            'published' => true,
            'published_at' => now()
        ]);
    }

    /**
     * Unpublish an existing resource.
     */
    public function unpublish()
    {
        return $this->update([
            'published' => false,
            'published_at' => null
        ]);
    }

    /**
     * Check if the resource is puvlished or not
     */
    public function isPublished(): bool
    {
        return $this->where('published', true);
    }
}
