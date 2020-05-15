<?php
namespace Backender\Contents\Widgets;

use Backender\Contents\Entities\Content;

interface WidgetInterface
{
    public function save($content, $identifier, $values);

    //public function getRules();
}

?>
