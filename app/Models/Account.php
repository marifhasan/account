<?php

namespace App\Models;

use App\AddressTrait;
use App\HistoryTrait;
use App\OpeningTrait;
use App\RemarkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, OpeningTrait, RemarkTrait, HistoryTrait, AddressTrait;

    /**
     * The accessors to append to the Account's array form.
     *
     * @var array
     */
    protected $appends = [
        'address',
        'balance',
        'remark',
        'opening_date',
        'opening_check',
        'opening_balance',
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
}
