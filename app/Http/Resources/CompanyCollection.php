<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    protected $withoutFields = [];

    // Transform the resource collection into an array.
    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    // Send fields to hide to CompanysResource while processing the collection.
    protected function processCollection($request)
    {
        return $this->collection->map(function (Company $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }
}
