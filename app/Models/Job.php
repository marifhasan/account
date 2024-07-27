<?php

namespace App\Models;

use App\HistoryTrait;
use App\RemarkTrait;
use App\StatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, HistoryTrait, RemarkTrait, StatusTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'expected_date' => 'datetime:Y-m-d',
        'delivery_date' => 'datetime:Y-m-d',
    ];

    /**
     * The accessors to append to the User's array form.
     *
     * @var array
     */
    protected $appends = [
        'status',
        'statuses',
        'remark',
        'client_name',
    ];

    /**
     * The Job's statuses.
     *
     * @var array
     */
    public $statuses = [
        'active' => 'Active',
        'pending' => 'Pending',
        'inactive' => 'Inactive',
    ];

    public $default_status = 'active';

    /**
     * Get the Model's remark.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function getClientNameAttribute()
    {
        return Client::find($this->client_id)?->name ?? 'client not found';
    }
}
