<?php

namespace App;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait TestimonialTrait
{
    /**
     * Get the Model's testimonial.
     */
    public function latest_testimonial()
    {
        return $this->morphOne(Testimonial::class, 'testimoniable')->latestOfMany();
    }

    /**
     * Get all of the Model's testimonials.
     */
    public function testimonials()
    {
        return $this->morphMany(Testimonial::class, 'testimoniable');
    }

    /**
     * Get the Trait testimonial.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function testimonial(): Attribute
    {
        return Attribute::get(fn () => $this->latest_testimonial);
    }
}
