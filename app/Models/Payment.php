<?php

namespace App\Models;

use App\HistoryTrait;
use App\RemarkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HistoryTrait, RemarkTrait;

    /**
     * The accessors to append to the User's array form.
     *
     * @var array
     */
    protected $appends = [
        'remark',

        'read_date',
        'account_name',
        'asset_name',
        'sector_name',
        'payment_type',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function getReadDateAttribute()
    {
        return $this->date ? date('Y-m-d', strtotime($this->date)) : '';
    }

    public function getAccountNameAttribute()
    {
        return $this->account?->name;
    }

    public function getAssetNameAttribute()
    {
        return $this->asset?->name;
    }

    public function getSectorNameAttribute()
    {
        return $this->sector?->name;
    }

    public function getPaymentTypeAttribute()
    {
        return $this->asset ? 'asset' : 'sector';
    }
}
