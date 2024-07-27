<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory, HistoryTrait;

    protected $fillable = [
        'note',
    ];

    /**
     * Get the parent remarkable model (Description).
     */
    public function remarkable()
    {
        return $this->morphTo();
    }
}
