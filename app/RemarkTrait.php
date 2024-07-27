<?php

namespace App;

use App\Models\Remark;

trait RemarkTrait
{
    /**
     * Get the Model's remark.
     */
    public function latest_remark()
    {
        return $this->morphOne(Remark::class, 'remarkable')->latestOfMany();
    }

    /**
     * Get all of the Model's remarks.
     */
    public function remarks()
    {
        return $this->morphMany(Remark::class, 'remarkable');
    }

    /**
     * Get the remark.
     *
     * @return string
     */
    public function getRemarkAttribute()
    {
        return $this->latest_remark?->note ?? '';
    }

    /**
     * Set the Model's remark.
     *
     * @param  string  $value
     * @return void
     */
    public function setRemarkAttribute($value)
    {
        if ($this->remark == '' && ! empty($value)) {
            $this->remarks()->save(new Remark([
                'note' => $value,
            ]));
        } elseif ($value != $this->remark) {
            $this->latest_remark->update(['note' => $value]);
        }
    }
}
