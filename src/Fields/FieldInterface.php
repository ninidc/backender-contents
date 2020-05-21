<?php
namespace Backender\Contents\Fields;

use Backender\Contents\Entities\Content;

interface FieldInterface
{
    public function save($content, $identifier, $values, $languages = null);

    public function getRules();
}

?>
