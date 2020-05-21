<?php

namespace Backender\Contents\Jobs\Language;

use Backender\Contents\Http\Requests\Language\CreateLanguageRequest;

use Backender\Contents\Entities\Language;

class CreateLanguage
{
    public function __construct($attributes)
    {
        $this->attributes = array_only($attributes, [
            'name',
            'iso',
            'default'
        ]);
    }

    public static function fromRequest(CreateLanguageRequest $request)
    {
        return new self($request->all());
    }

    public function handle()
    {
        if(isset($this->attributes['default']) && $this->attributes['default'] == "on"){
          $this->attributes['default'] = 1;

          //check default to null
          Language::where('default',1)->update([
              'default' => null
          ]);
        } else {
            $this->attributes['default'] = null;
        }

        return Language::create($this->attributes);
    }
}
