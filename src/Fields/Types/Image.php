<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;

class Image extends Field implements FieldInterface
{
    public $type = 'image';
    public $icon = 'fa-image';
    public $name = 'IMAGE';

    public $rules = [
        'required'
    ];

    public $settings = [
        'cropsAllowed',
        'htmlId',
        'htmlClass'
    ];

    public function save($content, $identifier, $media, $languages = null)
    {
        $mediaId = isset($media['id']) ? $media['id'] : null;

        if($mediaId) {
            return $content->fields()->save(new ContentField([
                'name' => $identifier,
                'value' => $mediaId,
                'relation' => 'medias'
            ]));
        }

        return false;
    }

}
?>
