<?php

namespace Backender\Contents\Fields\Types;

use Backender\Contents\Fields\Field;
use Backender\Contents\Fields\FieldInterface;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;

class File extends Field implements FieldInterface
{
    public $type = 'file';
    public $icon = 'far fa-file-pdf';
    public $name = 'FILE';

    public $rules = [
        'required'
    ];

    public $settings = [
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
