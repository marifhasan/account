<?php

namespace App;

use App\Models\Status;

trait StatusTrait
{
    /**
     * Get the Model's status.
     */
    public function latest_status()
    {
        return $this->morphOne(Status::class, 'statusable')->latestOfMany();
    }

    /**
     * Get all of the Model's statuses.
     */
    public function changeStatuses()
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    /**
     * Get the status.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->latest_status?->changed_status ?? $this->default_status ?? 'pending';
    }

    /**
     * Get the statuses.
     *
     * @return string
     */
    public function getStatusesAttribute()
    {
        return $this->statuses;
    }
}
