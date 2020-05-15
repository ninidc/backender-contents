<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class ElementFormButton extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa fa fa-list-alt';
    public $name = 'ELEMENT_FORM_BUTTON';
    public $component = 'CommonWidget';

    public $fields = [
        'title' => 'Backender\Contents\Fields\Types\Text',
        'icon' => 'Backender\Contents\Fields\Types\Text',
    ];

    public $rules = [];

    public $hidden = false;

    public $settings = [
        'formElementsV2',
        'conditionalVisibility',
        'buttonClass'
    ];
}
?>
