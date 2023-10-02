<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     *
     * The fields that are searchable.
     *
     */
    protected $searchableFields = [
        'name',
        'first_name',
        'last_name',
        'email'
    ];

    protected $with = [
        'roles'
    ];

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the questions for the user.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the comments of the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the answers of the user.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the likes of the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the user's most recent post.
     */
    public function latestPost()
    {
        return $this->hasOne(Post::class)->latestOfMany();
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }


    /**
     * The "booted" method of the model.
     */
    // protected static function booted(): void
    // {
    //     static::addGlobalScope('role', function (Builder $builder, User $user) {
    //         $builder->whereBelongsTo($user, 'roles')->get();
    //     });
    // }
}
