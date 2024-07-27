<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'note',
        'historyable',
        'user_id',
    ];

    /**
     * Get the parent historyable model (History).
     */
    public function historyable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    public function getCreatedAt()
    {
        return ! empty($this->created_at) ? Carbon::parse($this->created_at)->format('d/m/Y h:i a') : 'N/A';
    }
}
