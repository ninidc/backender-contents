<?php

namespace Backender\Contents\Entities;

use Illuminate\Database\Eloquent\Model;
use Backender\Contents\Traits\HasFields;

class Page extends Model
{
    use HasFields;

    protected $table = 'pages';

    protected $fillable = [
        'content_id',
        'definition',
        'settings'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function content()
    {
        return $this->hasOne('\Backender\Contents\Entities\Content');
    }
}
