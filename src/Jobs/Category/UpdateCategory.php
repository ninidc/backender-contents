<?php

namespace Backender\Contents\Jobs\Category;

use Backender\Contents\Http\Requests\Category\UpdateCategoryRequest;

use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\CategoryField;
use Backender\Contents\Entities\Language;

use Backender\Contents\Tasks\Urls\UpdateUrlsCategory;

class UpdateCategory
{
    public function __construct(Category $category, $attributes)
    {
        $this->category = $category;

        $fields = collect(Category::FIELDS)
            ->keyBy('identifier')
            ->keys()
            ->toArray();

        $this->attributes = array_only($attributes['fields'], $fields);
        $this->parent_id = isset($attributes['parent_id']) && $attributes['parent_id'] > 0 ? $attributes['parent_id'] : null;
    }

    public static function fromRequest(Category $category, UpdateCategoryRequest $request)
    {
        return new self($category, $request->all());
    }

    public function handle()
    {

        $order = $this->category->order;

        if($this->category->parent_id != $this->parent_id){
          if($this->parent_id != null){
            $order = Category::where("parent_id",$this->parent_id)->max('order');
            $order = $order + 1;
          }
          else {
            $order = Category::where("parent_id",null)->max('order');

            $order = $order + 1;
          }
        }

        $this->category->update([
            'parent_id' => $this->parent_id,
            'order' => $order
        ]);
        $this->category->fields()->delete();

        foreach($this->attributes as $identifier => $field) {
            foreach($field as $languageId => $value) {
                $this->category->fields()->save(new CategoryField([
                    'name' => $identifier,
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'language_id' => $languageId
                ]));
            }
        }

        (new UpdateUrlsCategory($this->category->load('fields')))->run();

        return $this->category->load('urls', 'fields');
    }
}
