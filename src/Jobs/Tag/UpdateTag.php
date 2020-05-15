<?php

namespace Backender\Contents\Jobs\Tag;

use Backender\Contents\Http\Requests\Tag\UpdateTagRequest;

use Backender\Contents\Entities\Tag;
use Backender\Contents\Entities\TagField;
use Backender\Contents\Entities\Language;

class UpdateTag
{
    public function __construct(Tag $tag, $attributes)
    {
        $this->tag = $tag;

        $fields = collect(Tag::FIELDS)
            ->keyBy('identifier')
            ->keys()
            ->toArray();

        $this->attributes = array_only($attributes['fields'], $fields);
    }

    public static function fromRequest(Tag $tag, UpdateTagRequest $request)
    {
        return new self($tag, $request->all());
    }

    public function handle()
    {
        $this->tag->fields()->delete();

        foreach($this->attributes as $identifier => $field) {
            foreach($field as $languageId => $value) {
                $this->tag->fields()->save(new TagField([
                    'name' => $identifier,
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'language_id' => $languageId
                ]));
            }
        }

        return $this->tag;
    }
}
