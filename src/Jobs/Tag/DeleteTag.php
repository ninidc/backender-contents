<?php

namespace Backender\Contents\Jobs\Tag;

use Backender\Contents\Http\Requests\Tag\DeleteTagRequest;
use Backender\Contents\Entities\Tag;

class DeleteTag
{
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public static function fromRequest(Tag $tag, DeleteTagRequest $request)
    {
        return new self($tag);
    }

    public function handle()
    {
        return $this->tag->delete();
    }
}
