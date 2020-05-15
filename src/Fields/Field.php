<?php

namespace Backender\Contents\Fields;

use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;
abstract class Field
{
    public function model()
    {
        return "Backender\\Contents\\Entities\\ContentField";
    }

    public function getLanguageFromIso($iso, $languages)
    {
        foreach($languages as $language) {
            if($language->iso == $iso) {
                return $language;
            }
        }
        return false;
    }

    public function save($content, $identifier, $values, $languages = null)
    {
        $languages = Language::getAllCached();
        $values = !is_array($values) ? [$values] : $values;

        foreach($values as $iso => $value) {
            $language = $this->getLanguageFromIso($iso, $languages);
            $content->fields()->save(new ContentField([
                'name' => $identifier,
                'value' => is_array($value) ? json_encode($value) : $value,
                'language_id' => $language ? $language->id : null
            ]));
        }

        return true;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return trans('architect::fields.' . $this->getType());
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function getSettings()
    {
        return $this->settings;
    }
}
?>
