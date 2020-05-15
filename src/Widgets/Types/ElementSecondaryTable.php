<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class ElementSecondaryTable extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa fa-table';
    public $name = 'ELEMENT_SECONDARY_TABLE';
    public $component = 'CommonWidget';

    public $fields = [
        'title' => 'Backender\Contents\Fields\Types\Text',
        'moreBtn' => 'Backender\Contents\Fields\Types\Link'
    ];

    public $rules = [
        'required'
    ];

    public $hidden = false;

    public $settings = [
        'maxItems',
        'pagination',
        'tableElements',
        'collapsable',
        'collapsed',
        'hiddenFilter',
        'conditionalVisibility'
    ];
}
?>
