<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;

class Localization extends Field implements FieldInterface
{
    public $type = 'localization';
    public $icon = 'fa-map-marker';
    public $name = 'LOCALIZATION';

    public $rules = [
        'required'
    ];

    public $settings = [
      'htmlId',
      'htmlClass'
    ];

    public function save($content, $identifier, $values, $languages = null)
    {
        if($content->fields()->save(new ContentField([
            'name' => $identifier,
            'value' => is_array($values) ? json_encode($values) : $values
        ]))) {
            return true;
        }

        return false;
    }

}
?>
