<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;

class ContentCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public $timestamps = false;
}
