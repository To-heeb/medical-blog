<?php

namespace App\Models;

use App\Events\LikeUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_id',
    ];


    /**
     * The event map for the model.
     *
     * @var array
     */
    // protected $dispatchesEvents = [
    //     'saved'     => LikeUpdated::class,
    //     'deleted'   => LikeUpdated::class,
    // ];


    /**
     * Get the parent likable model (user or post).
     */
    public function likeable()
    {
        return $this->morphTo();
    }
}
