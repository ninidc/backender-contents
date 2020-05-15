<?php

namespace Backender\Contents\Jobs\Translation;

use Backender\Contents\Http\Requests\Translation\CreateTranslationRequest;

use Backender\Contents\Entities\Translation;
use Backender\Contents\Entities\TranslationField;
use Backender\Contents\Entities\Language;
use Cache;

class CreateTranslation
{
    public function __construct($attributes)
    {
        $this->attributes = array_only($attributes, [
            'name',
            'fields'
        ]);
    }

    public static function fromRequest(CreateTranslationRequest $request)
    {
        return new self($request->all());
    }

    public function handle()
    {
        $translation = Translation::create([
          'name' => $this->attributes['name'],
          'order' => null !== Translation::max('order')? (Translation::max('order') + 1):0
        ]);

        foreach ($this->attributes['fields']['value'] as $languageId => $value) {
            $translation->fields()->save(new TranslationField([
                'translation_id' => $translation->id,
                'name' => $this->attributes['name'],
                'value' => is_array($value) ? json_encode($value) : $value,
                'language_id' => $languageId
            ]));
        }

        // OPTIMIZE : create task for it :)
        foreach(Language::getAllCached() as $language) {
            Cache::forget('localization.' . $language->iso);
        }

        return $translation;
    }
}
