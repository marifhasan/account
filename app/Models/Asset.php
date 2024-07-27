<?php

namespace App\Models;

use App\AddressTrait;
use App\HistoryTrait;
use App\OpeningTrait;
use App\RemarkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, OpeningTrait, RemarkTrait, HistoryTrait, AddressTrait;

    /**
     * The accessors to append to the Asset's array form.
     *
     * @var array
     */
    protected $appends = [
        'address',
        'balance',
        'type_name',
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

    /**
     * Get the balance.
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return $this->type?->name ?? 'type not found';
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
