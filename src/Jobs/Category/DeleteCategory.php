<?php

namespace Backender\Contents\Jobs\Category;

use Backender\Contents\Http\Requests\Category\DeleteCategoryRequest;

use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\Language;

class DeleteCategory
{
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public static function fromRequest(Category $category, DeleteCategoryRequest $request)
    {
        return new self($category);
    }

    public function handle()
    {
        //return $this->category->delete();
        $category = $this->category;

        //all children of this category has same parent
  			$oldParentId = $category->id;
  			$newParentId = $category->parent_id;

  			$parentNode = null;

  			if($category->parent_id != null){
  				$parentNode = Category::find($category->parent_id);
  			}

  			foreach(Category::where('parent_id',$category->id)->get() as $node){
  				if($parentNode != null)
  					$parentNode->appendNode($node);
  				else
  					$node->saveAsRoot();
  			}

        return $this->category->delete();

    }
}
