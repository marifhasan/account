<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HistoryTrait;

    protected $fillable = [
        'path',
    ];

    /**
     * Get the parent signaturable model (Signature).
     */
    public function signaturable()
    {
        return $this->morphTo();
    }
}
