<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Fields\Field;

class Richtext extends Field implements FieldInterface
{
    public $type = 'richtext';
    public $icon = 'fa-align-left';
    public $name = 'RICHTEXT';

    public $rules = [
        'required',
        'maxCharacters',
    ];

    public $settings = [
        'fieldHeight',
        'htmlId',
        'htmlClass'
    ];
}
?>
