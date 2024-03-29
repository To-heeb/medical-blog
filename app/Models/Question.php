<?php

namespace App\Models;

use App\Traits\Likeable;
use App\Events\ModelViewed;
use App\Traits\Publishable;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Question extends Model
{
    use HasFactory,
        Searchable,
        Publishable,
        Likeable;


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
        "published_at",
        'user_id'
    ];

    protected $with = [
        'user',
        'likes',
        'answers',
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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'retrieved'   => ModelViewed::class,
    ];


    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the user that owns the question.
     */
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    /**
     * Get all of the question's likes.
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
}
