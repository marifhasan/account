<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes, HistoryTrait;

    protected $fillable = [
        'path',
    ];

    /**
     * Get the parent documentable model (Document).
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
