<?php

namespace App;

use App\Models\History;

trait HistoryTrait
{
    /**
     * Get the Model's history.
     */
    public function latest_history()
    {
        return $this->morphOne(History::class, 'historyable')->latestOfMany();
    }

    /**
     * Get all of the Model's histories.
     */
    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }
}
