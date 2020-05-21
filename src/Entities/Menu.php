<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'name',
    ];

    public function elements()
    {
        return $this->hasMany('\Backender\Contents\Entities\MenuElement');
    }

    public function fields()
    {
        return $this->hasManyThrough('\Backender\Contents\Entities\MenuElementField', '\Backender\Contents\Entities\MenuElement');
    }

    public function scopeHasContent(Builder $query, $content)
    {
        return $query->whereHas('fields', function ($q) use ($content) {
            $q
                ->where('relation', 'content')
                ->where('value', $content->id);
        });
    }

    public function scopeHasName(Builder $query, $name)
    {
        return $query->where('name', $name);
    }
}
