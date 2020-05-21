<?php

namespace Backender\Contents\Tasks\Urls;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\Language;
use Backender\Contents\Entities\Url;

class CreateUrlsContent
{
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public function run()
    {
        return $this->content->is_page ? $this->createPageUrl() : $this->createContentUrl();
    }

    private function createPageUrl()
    {
        $content = $this->content;

        Language::getAllCached()->map(function($language) use ($content) {
            $url = $content->getFullSlug($language->id);

            $isMultiLanguage = env('ARCHITECT_MULTI_LANGUAGE', true);

            if($url) {
                $content->urls()->create([
                    'language_id' => $language->id,
                    'url' => $isMultiLanguage
                        ? '/' . $language->iso . "/" . $url
                        : "/" . $url
                ]);
            }
        });

        return true;
    }

    /*
     *  Build content url and save it
     *
     *  URLs schema :
     *      - Content with typology : /{typology_slug}/{content_slug}
     *      - Content with typology & category : /{typology_slug}/{category_slug}/../{content_slug}
     */
    private function createContentUrl()
    {
        if(!$this->content->typology->has_slug) {
            return false;
        }

        foreach(Language::getAllCached() as $language) {

            $isMultiLanguage = env('ARCHITECT_MULTI_LANGUAGE', true);

            $category = $this->content->categories()->first();

            if($category != null) {

              if($isMultiLanguage) {
                  $url = sprintf(
                      '/%s/%s/%s/%s',
                      $language->iso,
                      $this->content->typology->getSlug($language->id),
                      $category->getFieldValue('slug',$language->id),
                      $this->content->getFieldValue('slug', $language->id)
                  );
              } else {
                  $url = sprintf(
                      '/%s/%s/%s',
                      $this->content->typology->getSlug($language->id),
                      $category->getFieldValue('slug',$language->id),
                      $this->content->getFieldValue('slug', $language->id)
                  );
              }

            }
            else {
              if($isMultiLanguage) {
                  $url = sprintf(
                      '/%s/%s/%s',
                      $language->iso,
                      $this->content->typology->getSlug($language->id),
                      $this->content->getFieldValue('slug', $language->id)
                  );
              } else {
                  $url = sprintf(
                      '/%s/%s',
                      $this->content->typology->getSlug($language->id),
                      $this->content->getFieldValue('slug', $language->id)
                  );
              }
            }



            $this->content->urls()->create([
                'language_id' => $language->id,
                'url' => $url,
            ]);
        }

        // Save category slug by languages
        // if($this->content->typology->has_categories) {
        //     foreach($urls as $languageId => $url) {
        //         $category = $this->content->categories->first();
        //         if($category) {
        //             $urls[$languageId] .= $category->getFullSlug($languageId);
        //         }
        //     }
        // }

        return true;
    }
}
