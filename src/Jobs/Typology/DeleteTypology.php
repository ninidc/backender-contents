<?php

namespace Backender\Contents\Jobs\Typology;

use Backender\Contents\Http\Requests\Typology\DeleteTypologyRequest;
use Backender\Contents\Entities\Typology;

class DeleteTypology
{
    public function __construct(Typology $typology)
    {
        $this->typology = $typology;
    }

    public static function fromRequest(Typology $typology, DeleteTypologyRequest $request)
    {
        return new self($typology);
    }

    public function handle()
    {
        return $this->typology->delete();
    }
}
