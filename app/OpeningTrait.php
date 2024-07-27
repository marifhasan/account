<?php

namespace App;

use App\Models\Opening;

trait OpeningTrait
{
    /**
     * Get the Model's opening.
     */
    public function latest_opening()
    {
        return $this->morphOne(Opening::class, 'openingable')->latestOfMany();
    }

    /**
     * Get all of the Model's openings.
     */
    public function openings()
    {
        return $this->morphMany(Opening::class, 'openingable');
    }

    /**
     * Get the opening.
     *
     * @return string
     */
    public function getOpeningBalanceAttribute()
    {
        return $this->latest_opening?->balance ?? 0;
    }

    /**
     * Get the opening.
     *
     * @return string
     */
    public function getOpeningDateAttribute()
    {
        return $this->latest_opening ? date('Y-m-d', strtotime($this->latest_opening->date)) : null;
    }

    /**
     * Get the opening.
     *
     * @return string
     */
    public function getOpeningCheckAttribute()
    {
        return $this->latest_opening ? true : false;
    }

    /**
     * Set the Model's opening balance.
     *
     * @param  float  $value
     * @return void
     */
    public function setOpeningBalanceAttribute($value)
    {
        if (! $this->latest_opening && ! empty($value)) {
            $this->openings()->save(new Opening([
                'balance' => $value,
            ]));
        } elseif ($value != $this->opening_balance) {
            $this->latest_opening->update(['balance' => $value]);
        }
    }

    /**
     * Set the Model's opening date.
     *
     * @param  string  $value
     * @return void
     */
    public function setOpeningDateAttribute($value)
    {
        if (! $this->latest_opening && ! empty($value)) {
            $this->openings()->save(new Opening([
                'date' => $value,
            ]));
        } elseif ($value != $this->opening_date) {
            $this->latest_opening->update(['date' => $value]);
        }
    }
}
