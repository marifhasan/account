<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HistoryTrait;

    /**
     * The accessors to append to the User's array form.
     *
     * @var array
     */
    protected $appends = [
        'permissions',
    ];

    /**
     * Get the user's image path.
     *
     * @return string
     */
    public function getPermissionsAttribute()
    {
        return json_decode($this->permissions_list, true) ?? [];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
