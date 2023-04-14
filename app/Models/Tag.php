<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory, Searchable;


    /**
     * The fields that are searchable.
     *
     */
    protected $searchableFields = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
    ];


    /**
     * Get the route key for the model.
     */
    // public function getRouteKeyName(): string
    // {
    //     return 'name';
    // }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Get all of the questions that are assigned this tag.
     */
    public function questions(): MorphToMany
    {
        return $this->morphedByMany(Question::class, 'taggable');
    }
}
