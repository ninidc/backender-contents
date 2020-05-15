<?php

namespace Backender\Contents\Widgets\Types;

use Backender\Contents\Widgets\Widget;
use Backender\Contents\Widgets\WidgetInterface;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class TableDocument extends Widget implements WidgetInterface
{
    public $type = 'widget';
    public $icon = 'fa fa-table';
    public $name = 'TABLE_DOCUMENT';
    public $component = 'CommonWidget';

    public $fields = [
        'title' => 'Backender\Contents\Fields\Types\Text'
    ];

    public $rules = [
        'required'
    ];

    public $hidden = false;

    public $settings = [
      'collapsable',
      'collapsed',
      'bootstrapColumns',
      'tableElements',
      'conditionalVisibility',
      'itemsPerPage'
      
    ];
}
?>
