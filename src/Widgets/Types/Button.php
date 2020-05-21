<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class Button extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa-external-link-square';
    public $name = 'BUTTON';
    public $component = 'CommonWidget';

    public $fields = [
        'link' => 'Backender\Contents\Fields\Types\Link',
    ];

    public $rules = [
        'required'
    ];

    public $hidden = true;

    public $settings = [
        'htmlId',
        'htmlClass',
        'hiddenFilter',
        'conditionalVisibility'
    ];

}
?>
