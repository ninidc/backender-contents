<?php

namespace Backender\Contents\Tasks\Urls;

use Backender\Contents\Entities\Typology;
use Backender\Contents\Entities\Language;

class CreateUrlsTypology
{
    public function __construct(Typology $typology)
    {
        $this->typology = $typology;
    }

    public function run()
    {
        $typology = $this->typology;

        Language::getAllCached()->map(function($language) use ($typology) {
            $slug = $typology->getSlug($language->id);
            $isMultiLanguage = env('ARCHITECT_MULTI_LANGUAGE', true);

            if($slug) {
                $typology->urls()->create([
                    'language_id' => $language->id,
                    'url' => $isMultiLanguage
                        ? '/' . $language->iso . '/' . $slug
                        : '/' . $slug
                ]);
            }
        });
    }

}
