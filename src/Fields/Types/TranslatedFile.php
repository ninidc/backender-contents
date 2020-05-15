<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Language;

class TranslatedFile extends Field implements FieldInterface
{
    public $type = 'translated_file';
    public $icon = 'far fa-file-pdf';
    public $name = 'TRANSLATED_FILE';

    public $rules = [
        'required'
    ];

    public $settings = [
        'htmlId',
        'htmlClass'
    ];

    public function save($content, $identifier, $values, $languages = null)
    {

        $languages = Language::getAllCached();
        $values = !is_array($values) ? [$values] : $values;

        foreach($values as $iso => $value) {

            $language = $this->getLanguageFromIso($iso, $languages);

            $mediaId = isset($value['id']) ? $value['id'] : null;
            if($mediaId) {
                $content->fields()->save(new ContentField([
                    'name' => $identifier,
                    'value' => $mediaId,
                    'relation' => 'medias',
                    'language_id' => $language ? $language->id : null
                ]));
            }

        }

        return true;

    }

}
?>
