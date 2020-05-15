<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;

use Backender\Contents\Traits\HasFields;
use Kalnoy\Nestedset\NodeTrait;

class MenuElement extends Model
{
    use HasFields, NodeTrait;

    protected $fieldModel = 'Backender\Contents\Entities\MenuElementField';

    protected $table = 'menus_elements';

    protected $appends = ['name'];

    protected $fillable = [
        'menu_id',
        'order',
        'settings'
    ];

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo('\Backender\Contents\Entities\Menu');
    }

    public function elements()
    {
        return $this->hasMany('\Backender\Contents\Entities\MenuElementField', "id", "element_id");
    }

    public static function getTree($id)
    {
    	return self::descendantsOf($id)->sortBy('order')->toTree($id);
    }

    public static function getTreeIds($id)
    {
        $ids = [];

        foreach(self::descendantsOf($id) as $item){
            $ids[] = $item->id;
        }

        return $ids;
    }

    public function getNameAttribute()
    {
        $defaultLanguage = Language::getDefault();
        $defaultLanguageId = isset($defaultLanguage->id) ? $defaultLanguage->id : null;
        $index = "name";

        foreach($this->fields as $field) {
            if($field->name == $index) {
                return $this->getFieldValue($index, $defaultLanguageId);
            }
        }

        return null;
    }
}
