<?php

namespace App;

use App\Models\Description;

trait DescriptionTrait
{
    /**
     * Get the Model's description.
     */
    public function latest_description()
    {
        return $this->morphOne(Description::class, 'descriptionable')->latestOfMany();
    }

    /**
     * Get all of the Model's descriptions.
     */
    public function descriptions()
    {
        return $this->morphMany(Description::class, 'descriptionable');
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->latest_description?->description ?? '';
    }
}
