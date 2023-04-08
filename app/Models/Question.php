<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;


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
    ];

    protected $with = [
        'user',
        'likes',
        'answers'
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
}
