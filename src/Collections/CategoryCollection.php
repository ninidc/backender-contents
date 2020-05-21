<?php

namespace Backender\Contents\Collections;

use Backender\Contents\Transformers\CategoryTransformer;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($category) use ($request) {
                return (new CategoryTransformer($category))->toArray($request);
            }),
        ];
    }
}
