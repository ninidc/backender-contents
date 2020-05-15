<?php

namespace Backender\Contents\Jobs\PageLayout;

use Backender\Contents\Http\Requests\PageLayout\DeletePageLayoutRequest;
use Backender\Contents\Entities\PageLayout;

use Illuminate\Support\Facades\Schema;

class DeletePageLayout
{
    public function __construct(PageLayout $pageLayout)
    {
        $this->pageLayout = $pageLayout;
    }

    public static function fromRequest(PageLayout $pageLayout, DeletePageLayoutRequest $request)
    {
        return new self($pageLayout);
    }

    public function handle()
    {
        return $this->pageLayout->delete();
    }
}
