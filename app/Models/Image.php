<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HistoryTrait;

    protected $fillable = [
        'path',
    ];

    /**
     * Get the parent imageable model (Image).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
