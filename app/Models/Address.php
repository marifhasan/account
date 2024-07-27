<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes, HistoryTrait;

    protected $fillable = [
        'address',
    ];

    /**
     * Get the parent addressable model (Address).
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
