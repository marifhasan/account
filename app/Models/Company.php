<?php

namespace App\Models;

use App\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, ImageTrait;

    /**
     * The accessors to append to the User's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image',
        'photo_url',
    ];
}
