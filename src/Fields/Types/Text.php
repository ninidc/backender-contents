<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;

class Text extends Field implements FieldInterface
{
    public $type = 'text';
    public $icon = 'fa-font';
    public $name = 'TEXT';

    public $rules = [
        'required',
        'unique',
        'maxCharacters',
        'minCharacters'
    ];

    public $settings = [
        'entryTitle',
        'htmlId',
        'htmlClass',
        'textAlign'
    ];
}
?>
