<?php

namespace App\Models;

use App\AddressTrait;
use App\HistoryTrait;
use App\OpeningTrait;
use App\RemarkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasApiTokens, HasFactory, HistoryTrait, AddressTrait, OpeningTrait, RemarkTrait;

    /**
     * The accessors to append to the Client's array form.
     *
     * @var array
     */
    protected $appends = [
        'jobs',
        'address',
        'balance',
        'remark',
        'opening_date',
        'opening_check',
        'opening_balance',
    ];

    protected $fillable = [
        'name',
    ];

    /**
     * Get the balance.
     *
     * @return string
     */
    public function getBalanceAttribute()
    {
        return 0;
    }

    public function getJobsAttribute()
    {
        return $this->hasMany(Job::class)->get() ?? [];
    }
}
