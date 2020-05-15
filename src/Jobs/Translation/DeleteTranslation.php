<?php

namespace Backender\Contents\Jobs\Translation;

use Backender\Contents\Http\Requests\Translation\DeleteTranslationRequest;
use Backender\Contents\Entities\Translation;
use Backender\Contents\Entities\Language;
use Cache;

class DeleteTranslation
{
    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public static function fromRequest(Translation $translation, DeleteTranslationRequest $request)
    {
        return new self($translation);
    }

    public function handle()
    {
        // OPTIMIZE : create task for it :)
        foreach(Language::getAllCached() as $language) {
            Cache::forget('localization.' . $language->iso);
        }

        return $this->translation->delete();
    }
}
