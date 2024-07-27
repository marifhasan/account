<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Product extends JsonResource
{
    protected $withoutFields = [];

    public static function collection($resource)
    {
        return tap(new ProductCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    // Set the keys that are supposed to be filtered out
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    // Remove the filtered keys.
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'name' => $this->name,
            'generic_name' => $this->generic_name,
            'intro' => $this->intro,
            'description' => $this->description,
            'href' => $this->href,
            'icon' => $this->icon,
            'branding' => $this->branding,
            'testimonials' => count($this->testimonials) ? Testimonial::collection($this->testimonials) : [],

            'company_name' => $this->company?->name,
            'company_href' => $this->company?->href,
            'company_id' => $this->company_id,

            'photo' => $this->image,
            'photo_url' => $this->image && Storage::exists($this->image) ? Storage::url($this->image) : null,
            'photo_path' => $this->image && Storage::exists($this->image) ? Storage::path($this->image) : null,
            'photo_default' => asset('img/screenshot-1.jpg'),
        ]);
    }
}
