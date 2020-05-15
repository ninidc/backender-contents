<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Builder;

use Backender\Contents\Entities\Language;

use Backender\Contents\Traits\HasFields;
use Backender\Contents\Traits\HasUrl;
use Backender\Contents\Traits\Searchable;

class Content extends Model
{
    use HasFields,
        HasUrl,
        NodeTrait,
        Searchable;

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    protected $fieldModel = 'Backender\Contents\Entities\ContentField';

    protected $appends = [
        'title',
        'url'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'typology_id',
        'user_id',
        'parent_id',
        'is_page',
        'published_at',
        'settings'
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
        'deleted_at',
        'published_at'
    ];

    /*
     *  Relations
     */
    public function typology()
    {
        return $this->hasOne('\Backender\Contents\Entities\Typology', "id", "typology_id");
    }

    public function tags()
    {
        return $this->belongsToMany('\Backender\Contents\Entities\Tag', 'contents_tags');
    }

    public function languages()
    {
        return $this->belongsToMany('\Backender\Contents\Entities\Language', 'contents_languages');
    }

    public function categories()
    {
        return $this->belongsToMany('\Backender\Contents\Entities\Category', 'contents_categories',  'content_id', 'category_id');
    }

    public function page()
    {
        return $this->belongsTo('\Backender\Contents\Entities\Page', 'id', 'content_id');
    }

    public function parent()
    {
    	  return $this->hasOne('\Backender\Contents\Entities\Content', 'id', 'parent_id');
    }

    public function routesParameters()
    {
        return $this->belongsToMany('\Modules\Extranet\Entities\RouteParameter', 'contents_routes_parameters',  'content_id', 'route_parameter_id')
          ->withPivot('preview_default_value','settings');
    }

    /*
    *   Return route parametesr with settings processed.
    */
    public function getRouteParametersWithSettings()
    {
        $parameters = $this->routesParameters()->get();
        if(isset($parameters)){
            $resultParameters = [];
            foreach($parameters as $parameter){
              $resultParameters[$parameter->identifier] = [
                "identifier" => $parameter->identifier,
                "required" => $parameter->isRequired()
              ];
            }
            return $resultParameters;
        }
        else {
          return null;
        };
    }

    public function isStatusPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }

    public function getStringStatus()
    {
        $status = [
            1 => trans('architect::contents.published'),
            0 => trans('architect::contents.draft'),
            self::STATUS_PUBLISHED => trans('architect::contents.published'), //'Publicat',//__('contents.status.published'),
            self::STATUS_DRAFT => trans('architect::contents.draft') //'Esborrany' //__('contents.status.draft')
        ];

        return isset($status[$this->status]) ? $status[$this->status] : null;
    }


    public function getTitleAttribute($language = null)
    {
        $defaultLanguage = $language ? $language : Language::getDefault();
        $defaultLanguageId = isset($defaultLanguage->id) ? $defaultLanguage->id : null;

        if($this->page) {
            return $this->getFieldValue('title', $defaultLanguageId);
        }

        if(!$this->fields || !$this->typology) {
            return null;
        }

        $index = $this->typology->getIndexField();

        if(!$index) {
            return null;
        }

        foreach($this->fields as $field) {
            if($field->name == $index) {
                return $this->getFieldValue($index, $defaultLanguageId);
            }
        }

        return null;
    }

    public static function getTree($id)
    {
      return Content::descendantsOf($id)->toTree($id);
    }

    public static function getTreeIds($id)
    {
        $ids = [];
        $contents = Content::descendantsOf($id);

        foreach($contents as $content){
            $ids[] = $content->id;
        }

        return $ids;
    }


    public function getSettings()
    {
        if($this->settings && $this->settings != null) {
          return json_decode($this->settings,true);
        }

        return null;
    }


    /*
     *  Scopes
     */
     public function scopeField($query, $name, $value)
     {
         return $query->where([
             'name' => $name,
             'value' => $value,
         ]);
     }

     public function scopeTypologyId($query, $typologyId)
     {
         $typologyId = $typologyId && !is_array($typologyId) ? array($typologyId) : $typologyId;

         return $typologyId ? $query->whereIn('typology_id', $typologyId) : $query;
     }

     public function scopeCategoryId($query, $categoryId)
     {
         $categoryId = $categoryId && !is_array($categoryId) ? array($categoryId) : $categoryId;

         return $categoryId ? $query->whereHas('categories', function($q) use($categoryId) {
             $q->whereIn('category_id', $categoryId);
         }) : $query;
     }

    public function scopeIsPublished(Builder $query)
    {
        return $query->where('status', 1);
    }

    public function scopeIsNotPublished(Builder $query)
    {
        return $query->where('status', 0);
    }

    public function scopeIsPage(Builder $query)
    {
        return $query->where('is_page', 1);
    }

    public function scopeIsNotPage(Builder $query)
    {
        return $query->where('is_page', 0);
    }

    public function scopeLanguageIso(Builder $query, $acceptLang)
    {
        return $acceptLang ? $query->whereHas('languages', function($q) use($acceptLang) {
            $q->where('iso', $acceptLang);
        }) : $query;
    }

    public function scopeByTagsIds(Builder $query, $tagsId)
    {
        $tagsId = $tagsId && !is_array($tagsId) ? array($tagsId) : $tagsId;

        return $tagsId ? $query->whereHas('tags', function($q) use($tagsId) {
            $q->whereIn('tag_id', $tagsId);
        }) : $query;
    }

    public function delete()
    {
        $this->languages()->delete();

        return parent::delete();
    }
}
