<?php

namespace Backender\Contents\Tasks\Urls;

use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\Language;
use Backender\Contents\Entities\Url;

use Backender\Contents\Tasks\Urls\UpdateUrlsContent;
use Backender\Contents\Tasks\Urls\CreateUrlsCategory;

class UpdateUrlsCategory
{
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function run()
    {
        // Update Category url
        $this->category->urls()->delete();

        (new CreateUrlsCategory($this->category))->run();

        // Update Category childrens urls & childrens contents Urls
        $languages = Language::getAllCached();

        $traverse = function ($categories) use (&$traverse, $languages) {
            foreach ($categories as $category) {
                (new UpdateUrlsCategory($category))->run();

                if($category->children) {
                    $traverse($category->children);
                }
            }
        };

        // Update contents URLS
        // $this->category->contents->map(function($content){
        //     (new UpdateUrlsContent($content))->run();
        // });

        if($this->category->children) {
            $traverse($this->category->children);
        }

        // Update Typology
    }

}
