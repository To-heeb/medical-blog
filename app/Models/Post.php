<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Searchable;

    /**
     * The fields that are searchable.
     *
     */
    protected $searchableFields = [
        'title',
        'slug'
    ];

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
        'user_id',
        'category_id'
    ];

    protected $with = [
        'user',
        'likes',
        'comments'
    ];


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
     * Get the user's most liked post.
     */
    public function bestPost()
    {
        return $this->morphOne(Like::class, 'likeable')->ofMany('likes', 'max');
    }

    /**
     * return the excerpt of the post content
     */
    public function excerpt(int $length = 50): string
    {
        return Str::limit($this->content, $length);
    }
}
