<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class BannerSlide extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa-picture-o';
    public $name = 'BANNER_SLIDE';
    public $component = 'CommonWidget';

    public $fields = [
        'image' => 'Backender\Contents\Fields\Types\Image',
        'title' => 'Backender\Contents\Fields\Types\Text',
        'subtitle' => 'Backender\Contents\Fields\Types\Text',
        'url' => 'Backender\Contents\Fields\Types\Url'
    ];

    public $rules = [
        'required'
    ];

    public $hidden = true;

    public $settings = [
        'htmlId',
        'htmlClass',
        'cropsAllowed',
    ];

}
?>
