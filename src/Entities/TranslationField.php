<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;

class TranslationField extends Model
{
    protected $table = 'translations_fields';

    protected $fillable = [
        'translation_id',
        'language_id',
        'name',
        'value',
    ];

    public $timestamps = false;

    public function translation()
    {
        return $this->belongsTo('\Backender\Contents\Entities\Translation');
    }
}
