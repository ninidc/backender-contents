<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

class BoxButton extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fas fa-external-link-square-alt';
    public $name = 'BOX_BUTTON';
    public $component = 'CommonWidget';

    public $fields = [
        'url' => 'Backender\Contents\Fields\Types\Url',
        'title' => 'Backender\Contents\Fields\Types\Text',
        'icon' => 'Backender\Contents\Fields\Types\Text',
        'image' => 'Backender\Contents\Fields\Types\Image',
    ];

    public $rules = [
        'required',
    ];

    public $hidden = false;

    public $settings = [
        'htmlId',
        'htmlClass',
        'hiddenFilter',
        'conditionalVisibility',
        'buttonClass',
        'cropsAllowed',
        'backgroundColor',
        'backgroundHoverColor'
    ];
}
