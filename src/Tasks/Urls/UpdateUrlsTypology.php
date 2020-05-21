<?php

namespace Backender\Contents\Tasks\Urls;

use Backender\Contents\Entities\Typology;
use Backender\Contents\Entities\Language;
use Backender\Contents\Entities\Url;

use Backender\Contents\Tasks\Urls\UpdateUrlsContent;

class UpdateUrlsTypology
{
    public function __construct(Typology $typology)
    {
        $this->typology = $typology;
    }

    public function run()
    {
        // If typology no has slug then we don't need to build URLs
        if(!$this->typology->has_slug) {
            return false;
        }

        // Delete URLs of the typology
        $this->typology->urls()->delete();

        // Build URLs of the typology
        Language::getAllCached()->map(function($language) {

            $attr = $this->typology->attrs->where('name', 'slug')
                ->where('language_id', $language->id)
                ->first();

            if(isset($attr->value)) {

                $isMultiLanguage = env('ARCHITECT_MULTI_LANGUAGE', true);

                if($isMultiLanguage) {
                    $url = sprintf('/%s/%s',
                        $language->iso,
                        $attr->value
                    );
                } else {
                    $url = sprintf('/%s',
                        $attr->value
                    );
                }

                $this->typology->urls()->create([
                    'language_id' => $language->id,
                    'url' => $url
                ]);
            }
        });

        // Refresh typology attributes
        $this->typology->load('attrs', 'fields');

        // Update all contents urls
        $this->typology->contents->map(function($content) {
            (new UpdateUrlsContent($content))->run();
        });
    }

}
