<?php

namespace Backender\Contents\Transformers;

use Backender\Contents\Entities\Language;
use Illuminate\Http\Resources\Json\Resource;

class CategoryTransformer extends Resource
{
    public function toArray($request, $language = null, $recursive = false)
    {
        $language = $request->get('accept_lang')
            ? Language::byIso($request->get('accept_lang'))->first()
            : $language;

        $payload = [
            'id' => $this->id,
            'name' => $this->getFieldValue('name', $language ? $language->id : null),
            'slug' => $this->getFieldValue('slug', $language ? $language->id : null),
            'description' => $this->getFieldValue('description', $language ? $language->id : null),
        ];

        if ($request->get('loads')) {
            if (in_array('contents', explode(',', $request->get('loads')))) {
                $payload['contents'] = $this->contents->map(function ($content) use ($request) {
                    return (new ContentTransformer($content))->toArray($request);
                })->toArray();
            }

            if (in_array('descendants', explode(',', $request->get('loads')))) {
                $payload['descendants'] = $this->descendants->map(function ($category) use ($request) {
                    return (new self($category))->toArray($request);
                })->toArray();
            }
        }

        return $payload;
    }
}
