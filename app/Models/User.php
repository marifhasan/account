<?php

namespace App\Models;

use App\DocumentTrait;
use App\HistoryTrait;
use App\ImageTrait;
use App\StatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use StatusTrait, ImageTrait, HistoryTrait, DocumentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
        'date_of_birth' => 'datetime',
        'joining_date' => 'datetime',
    ];

    /**
     * The accessors to append to the User's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image',
        'photo_url',
        'status',
        'statuses',
    ];

    /**
     * The User's statuses.
     *
     * @var array<string, string>
     */
    public $statuses = [
        'pending' => 'bg-yellow-500 text-gray-900',
        'active' => 'bg-green-500 text-green-900',
        'inactive' => 'bg-red-500 text-red-900',
    ];

    /**
     * The User's default status.
     *
     * @var array
     */
    public $default_status = 'active';

    /**
     * Get the user's department.
     *
     * @return string
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user's designation.
     *
     * @return string
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->image && Storage::exists($this->image) ? Storage::url($this->image) : null;
    }
}
