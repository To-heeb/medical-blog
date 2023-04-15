<?php

namespace App\Models;

use App\Traits\Likeable;
use App\Events\LikeUpdated;
use App\Traits\Publishable;
use Illuminate\Support\Str;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory,
        Searchable,
        Publishable,
        Likeable;


    /**
     * The event map for the model.
     *
     * @var array
     */
    // protected $dispatchesEvents = [
    //     'retrieved'   => LikeUpdated::class,
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'view_count',
        'published',
        'published_at',
        'user_id',
        'category_id'
    ];

    protected $with = [
        'user',
        'likes',
        'comments',
        'tags'
    ];

    /**
     * The fields that are searchable.
     *
     */
    protected $searchableFields = [
        'title',
        'slug',
        'content'
    ];

    /**
     * Get the post's category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(user::class);
    }


    /**
     * Get all of the post's likes.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    /**
     * Get all of the tags for the post.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the user's most liked post.
     */
    public function mostLikedPost()
    {
        return $this->withCount('likes')
            ->with('likes')
            ->orderByDesc('likes_count')
            ->first();
    }

    /**
     * return the excerpt of the post content
     */
    public function excerpt(int $length = 50): string
    {
        return Str::limit($this->content, $length);
    }
}
