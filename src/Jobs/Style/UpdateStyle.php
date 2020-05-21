<?php

namespace Backender\Contents\Jobs\Style;

use Illuminate\Http\Request;

use Backender\Contents\Entities\Style;
use Backender\Contents\Transformers\StyleFormTransformer;

use Backender\Contents\Fields\FieldConfig;
use Cache;

class UpdateStyle
{
     public function __construct(Style $style, $attributes)
     {
         $this->style = $style;
         $this->attributes = array_only($attributes, [
             'fields'
         ]);
     }

    public static function fromRequest(Style $style, Request $request)
    {
        return new self($style, $request->all());
    }

    public function handle()
    {

        $this->saveFields();

        $seconds = 24*3600;
        $storedStyles = (new StyleFormTransformer($this->style))->toArray();
        Cache::put($this->style->identifier.'Styles', $storedStyles, $seconds);

        return $this->style;
    }


    public function saveFields()
    {
        $this->style->fields()->delete();

        foreach($this->attributes["fields"] as $key => $field) {
            $info = [];
            $identifier = $key;
            $info['type'] = isset($field["type"]) ? $field["type"] : null;
            if($info['type'] == 'image'){
              $info['value'] = isset($field["value"]) && isset($field["value"]["id"])?$field["value"]["id"]: null;
            }else{
              $info['value'] = isset($field["value"]) ? $field["value"] : null;
            }

            $this->style->fields()->create([
              'language_id' => 1,
              'name' => $identifier,
              'value' => json_encode($info)
            ]);

        }
    }

}
