<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * Get the parent testimoniable model (user or post).
     */
    public function testimoniable()
    {
        return $this->morphTo();
    }
}
