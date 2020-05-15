<?php

namespace Backender\Contents\Ressources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use Backender\Contents\Transformers\TranslationTransformer;

class TranslationCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {        
        return [
            'data' => $this->collection->map(function($translation) use ($request){
                return (new TranslationTransformer($translation))->toArray($request);
            })
        ];
    }


}
