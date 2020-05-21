<?php

namespace Backender\Contents\Jobs\Language;

use Backender\Contents\Http\Requests\Language\UpdateLanguageRequest;

use Backender\Contents\Entities\Language;

class UpdateLanguage
{
    public function __construct(Language $language,$attributes)
    {
        $this->language = $language;

        $this->attributes = array_only($attributes, [
            'name',
            'iso',
            'default'
        ]);
    }

    public static function fromRequest(Language $language,UpdateLanguageRequest $request)
    {
        return new self($language,$request->all());
    }

    public function handle()
    {
        if(isset($this->attributes['default']) && $this->attributes['default'] == "on"){
          $this->attributes['default'] = 1;
          //check all default to null
          Language::where('default',1)->update(['default' => null]);
        }
        else {
          $this->attributes['default'] = null;
        }

        $this->language->update($this->attributes);

        return $this->language;
    }
}
