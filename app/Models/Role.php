<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpattieRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpattieRole
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'pivot',
        'created_at',
        'updated_at',
        'guard_name'
    ];
}
