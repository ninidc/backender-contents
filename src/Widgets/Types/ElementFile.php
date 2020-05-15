<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class ElementFile extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa fa-columns';
    public $name = 'ELEMENT_FILE';
    public $component = 'CommonWidget';

    public $fields = [
        'title' => 'Backender\Contents\Fields\Types\Text',
        'link' => 'Backender\Contents\Fields\Types\Link'
    ];

    public $rules = [
        'required'
    ];

    public $hidden = false;

    public $settings = [
        'fileElements',
        'collapsable',
        'collapsed',
        'doubleColumn',
        'hiddenFilter',
        'conditionalVisibility'
    ];
}
?>
