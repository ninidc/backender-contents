<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class Separator extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fas fa-arrows-alt-v';
    public $name = 'SEPARATOR';
    public $component = 'CommonWidget';
    
    public $fields = [];

    public $rules = [];

    public $hidden = true;

    public $settings = [
        'htmlId',
        'htmlClass',
        'height'
    ];

}
?>
