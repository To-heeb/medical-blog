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
     * return the excerpt of the post content
     */

    public function excerpt(int $length = 50): string
    {
        return Str::limit($this->content, $length);
    }
}
