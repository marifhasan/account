<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class PaymentSector extends Model
{
    use HistoryTrait;

    protected $fillable = [
        'name',
    ];

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }
}
