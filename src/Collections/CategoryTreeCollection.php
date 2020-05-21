<?php

namespace Backender\Contents\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

use Backender\Contents\Transformers\CategoryTransformer;

class CategoryTreeCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
     public function toArray($request)
    {
        $traverse = function ($categories) use (&$traverse, $request) {

            $categoriesArray = [];
            foreach ($categories as $category) {
                
                $traverse($category->descendants);
                $categoriesArray[] = (new CategoryTransformer($category))->toArray($request);
            }

            return $categoriesArray;
        };

        return [
            'data' => $traverse($this->collection)
        ];
    }


}
