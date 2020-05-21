<?php

namespace Backender\Contents\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MediaModalDatatableCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select(
                'medias.*'
            )
            ->type(request('type'))
            ->orderBy('created_at', 'desc');
    }
}
