<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class StaticBanner extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa fa-pencil-square-o';
    public $name = 'STATIC_BANNER';
    public $component = 'CommonWidget';

    public $fields = [
    //    'name' => 'Backender\Contents\Fields\Types\Text',
    //    'icon' => 'Backender\Contents\Fields\Types\Text',
    //    'url' => 'Backender\Contents\Fields\Types\Url',
    ];

    public $rules = [
        'required'
    ];

    public $hidden = false;

    public $settings = [
      'htmlId',
      'htmlClass',
      'hiddenFilter',
      'conditionalVisibility'
    ];
}
?>
