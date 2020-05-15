<?php

namespace Backender\Contents\Jobs\Category;

use Backender\Contents\Http\Requests\Category\CreateCategoryRequest;

use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\CategoryField;
use Backender\Contents\Entities\Language;
use Backender\Contents\Tasks\Urls\CreateUrlsCategory;

class CreateCategory
{
    public function __construct($attributes)
    {
        $fields = collect(Category::FIELDS)
            ->keyBy('identifier')
            ->keys()
            ->toArray();

        $this->attributes = array_only($attributes['fields'], $fields);
        $this->parent_id = isset($attributes['parent_id']) && $attributes['parent_id'] > 0 ? $attributes['parent_id'] : null;
    }

    public static function fromRequest(CreateCategoryRequest $request)
    {
        return new self($request->all());
    }

    public function handle()
    {

        $order = 0;

        if($this->parent_id != null){
          $order = Category::where("parent_id",$this->parent_id)->max('order');
          $order = $order + 1;
        } else {
          $order = Category::where("parent_id",null)->max('order');
          $order = $order + 1;
        }

        $category = Category::create([
            'parent_id' => $this->parent_id,
            'order' => $order
        ]);

        foreach($this->attributes as $identifier => $field) {
            foreach($field as $languageId => $value) {
                $category->fields()->save(new CategoryField([
                    'name' => $identifier,
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'language_id' => $languageId
                ]));
            }
        }

        (new CreateUrlsCategory($category))->run();

        return $category;
    }
}
