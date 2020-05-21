<?php

namespace Backender\Contents\Fields\Rules;

class MaxItems
{
    public $name = "maxItems";

    public function validate($value, $param, $identifier)
    {

    }

    public function message()
    {
        return 'max items !';
    }
}
