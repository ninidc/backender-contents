<?php

namespace Backender\Contents\Jobs\Typology;

use Backender\Contents\Http\Requests\Typology\CreateTypologyRequest;
use Backender\Contents\Entities\Typology;
use Backender\Contents\Entities\TypologyAttribut;
use Backender\Contents\Entities\Field;
use Backender\Contents\Entities\Language;
use Backender\Contents\Tasks\Urls\CreateUrlsTypology;

class CreateTypology
{

    public function __construct($attributes)
    {
        $this->attributes = array_only($attributes, [
            'name',
            'fields',
            'identifier',
            'icon',
            'has_categories',
            'has_tags',
            'has_slug',
            'slug'
        ]);
    }

    public static function fromRequest(CreateTypologyRequest $request)
    {
        return new self($request->all());
    }

    public function handle()
    {
        $typology = Typology::create([
            'name' => $this->attributes["name"],
            'identifier' => $this->attributes["identifier"],
            'icon' => isset($this->attributes["icon"]) ? $this->attributes["icon"] : null,
            'has_categories' => isset($this->attributes["has_categories"]) ? $this->attributes["has_categories"] : null,
            'has_tags' => isset($this->attributes["has_tags"]) ? $this->attributes["has_tags"] : null,
            'has_slug' => isset($this->attributes["has_slug"]) ? $this->attributes["has_slug"] : null,
        ]);

        foreach($this->attributes["fields"] as $field) {
            $typology->fields()->save(new Field([
                'icon' => $field['icon'],
                'name' => $field['name'],
                'identifier' => $field['identifier'],
                'type' => $field['type'],
                'rules' => isset($field['rules']) ? $field['rules'] : null,
                'settings' => $field['settings'],
            ]));
        }

        if(isset($this->attributes["slug"]) && $typology->has_slug) {
            foreach($this->attributes["slug"] as $iso => $value) {
                $language = Language::where('iso', $iso)->first();

                if($language) {
                    $typology->attrs()->save(new TypologyAttribut([
                        'name' => 'slug',
                        'value' => $value,
                        'language_id' => $language->id
                    ]));
                }
            }
        }

        (new CreateUrlsTypology($typology))->run();

        return $typology;
    }
}
