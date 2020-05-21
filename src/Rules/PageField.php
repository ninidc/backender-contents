<?php

namespace Backender\Contents\Rules;

use Illuminate\Contracts\Validation\Rule;

use Backender\Contents\Fields\FieldValidator;

use Backender\Contents\Fields\Rules\Required;
use Backender\Contents\Fields\Rules\Unique;

class PageField implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $values)
    {
        foreach($values as $field) {
            $value = isset($field["value"]) ? $field["value"] : null;
            $identifier = isset($field["identifier"]) ? $field["identifier"] : null;

            $rule = new Required();
            $error = $rule->validate($value, true, $identifier);

            if($error) {
                $this->errors[$identifier] = $error;
            }

            switch($identifier) {
                case "slug":
                    $rule = new Unique();
                    $error = $rule->validate($value, true, $identifier);

                    if($error) {
                        $this->errors[$identifier] = $error;
                    }
                break;
            }
        }


        return empty($this->errors) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errors;
    }
}
