<?php

namespace Backender\Contents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use Backender\Contents\Entities\Style;
use Lang;

class StyleRepository extends BaseRepository
{
    public function model()
    {
        return "Backender\\Contents\\Entities\\Style";
    }

  
}
