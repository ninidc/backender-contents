<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;
use Backender\Contents\Traits\HasFields;
use Backender\Contents\Traits\HasUrl;
use Kalnoy\Nestedset\NodeTrait;
use Backender\Contents\Entities\ContentCategory;

class Category extends Model
{
    use HasFields, HasUrl, NodeTrait;

    protected $fieldModel = 'Backender\Contents\Entities\CategoryField';
    protected $appends = ['name', 'url'];

    const FIELDS = [
        [
            'name' => 'name',
            'identifier' => 'name',
            'type' => 'text',
            'required' => true
        ],
        [
            'name' => 'slug',
            'identifier' => 'slug',
            'type' => 'slug',
            'required' => true
        ],
        [
            'name' => 'description',
            'identifier' => 'description',
            'type' => 'richtext'
        ],
    ];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'order',
    ];

    /**
     * The attributes that are hidden from serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getNameAttribute()
    {
        if($this->fields) {
            foreach($this->fields as $field) {
                if($field->name == 'name') {
                    return $this->getFieldValue($field->name);
                }
            }
        }
        return null;
    }

    public function contents()
    {
        return $this->belongsToMany('\Backender\Contents\Entities\Content', 'contents_categories');
    }

    public function parent()
    {
    	return $this->hasOne('Backender\Contents\Entities\Category', 'id', 'parent_id');
    }

    public static function getTree($id)
    {
    	return Category::descendantsOf($id)->sortBy('order')->toTree($id);
    }

    public static function getTreeIds($id)
    {
        $ids = [];
        $categories = Category::descendantsOf($id);

        foreach($categories as $category){
            $ids[] = $category->id;
        }

        return $ids;
    }

    public function scopeByTypologyId($query, $typologyId)
    {
        $result = $typologyId ? $query->whereHas('contents', function($q) use($typologyId) {
            $q->where('typology_id', $typologyId);
        }) : $query;

        return $result;

    }

    public function scopeById($query, $id)
    {
        return $id ? $query->where('id', $id) : $query;
    }
}
