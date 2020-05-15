<?php

namespace Backender\Contents\Jobs\Category;

use Backender\Contents\Http\Requests\Category\UpdateCategoryOrderRequest;

use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\CategoryField;
use Backender\Contents\Entities\Language;

class UpdateCategoryOrder
{
    public function __construct( $attributes)
    {

        $this->attributes = $attributes;

    }

    public static function fromRequest(UpdateCategoryOrderRequest $request)
    {
        return new self($request->all());
    }

    public function handle()
    {

        $order = $this->attributes['order'];

    		$traverse = function ($parent_id,$children) use (&$traverse) {

    				$order = 1;

    				foreach ($children as $categoryItem) {

    					$category_id = $categoryItem['id'];

    					//update category with theme_id, $parent_id,$order
    					$category = Category::find($category_id);
    					$category->order = $order;
    					$category->parent_id = $parent_id;
    					$category->save();

    					$order++;

    					if(isset($categoryItem['children'])){
    						$children = $categoryItem['children'][0];

    						$traverse($category_id,$children);
    					}
            }
    	  };


    		$traverse(null,$order[0],$order);

        return true;

    }
}
