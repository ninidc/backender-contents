<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;

class Boolean extends Field implements FieldInterface
{
    public $type = 'boolean';
    public $icon = 'fa-check-square';
    public $name = 'BOOLEAN';

    public $rules = [
        'required'
    ];

    public $settings = [
        'htmlId',
        'htmlClass'
    ];

    public function validate($request)
    {}

    public function save($content, $identifier, $values, $languages = null)
    {
        return parent::save($content, $identifier, $values, $languages);
    }

}
?>
