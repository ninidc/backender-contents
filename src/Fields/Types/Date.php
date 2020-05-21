<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;

class Date extends Field implements FieldInterface
{
    public $type = 'date';
    public $icon = 'fa-calendar';
    public $name = 'DATE';

    public $rules = [
        'required'
    ];

    public $settings = [
      'htmlId',
      'htmlClass'
    ];

    public function save($content, $identifier, $values, $languages = null)
    {
        $content->fields()->save(new ContentField([
            'name' => $identifier,
            'value' => strtotime($values),
            'language_id' => null
        ]));

        return true;
    }
}
?>
