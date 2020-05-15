<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;

class Slug extends Field implements FieldInterface
{
    public $type = 'slug';
    public $icon = 'fa-link';
    public $name = 'SLUG';

    public $rules = [
        'required',
        'unique'
    ];

    public $settings = [];
}
?>
