<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HistoryTrait;

    protected $fillable = [
        'previous_status', 'changed_status', 'user_id',
    ];

    /**
     * Get the parent statusable model (Status).
     */
    public function statusable()
    {
        return $this->morphTo();
    }
}
