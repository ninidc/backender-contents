<?php

namespace Backender\Contents\Jobs\Language;

use Backender\Contents\Http\Requests\Language\DeleteLanguageRequest;
use Backender\Contents\Entities\Language;

class DeleteLanguage
{
    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public static function fromRequest(Language $language, DeleteLanguageRequest $request)
    {
        return new self($language);
    }

    public function handle()
    {
        return $this->language->delete();
    }
}
