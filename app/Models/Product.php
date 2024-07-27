<?php

namespace App\Models;

use App\ImageTrait;
use App\TestimonialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, TestimonialTrait, ImageTrait;

    /**
     * The accessors to append to the Product's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'testimonial',
        'image',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
