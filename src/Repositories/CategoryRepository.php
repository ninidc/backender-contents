<?php

namespace Backender\Contents\Repositories;

use Backender\Contents\Entities\Category;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return 'Backender\\Contents\\Entities\\Category';
    }

    public function getTree()
    {
        $categoryTree = [];
        $level = 1;

        $traverse = function (&$categoryTree, $categories, $fieldname, $level) use (&$traverse) {
            ++$level;

            foreach ($categories as $category) {
                array_push($categoryTree, [
                    'name' => $category->getNameAttribute(),
                    'id' => $category->id,
                    'parent_id' => $category->parent_id,
                    'order' => $category->order,
                    'level' => $level,
                ]);

                $traverse($categoryTree, $category->children, $fieldname, $level);
            }
        };

        $categories = Category::orderBy('order', 'ASC')->get();

        foreach ($categories as $category) {
            if (!$category->parent_id) {
                array_push($categoryTree, [
                    'name' => $category->getNameAttribute(),
                    'id' => $category->id,
                    'parent_id' => $category->parent_id,
                    'order' => $category->order,
                    'level' => $level,
                ]);

                //all parents
                $traverse($categoryTree, Category::getTree($category->id), 'category_id', $level);
            }
        }

        return  $categoryTree;
    }

    public function getTreeWithHyphens()
    {
        $categoryTree = [];
        $level = 1;

        $traverse = function (&$categoryTree, $categories, $fieldname, $level) use (&$traverse) {
            ++$level;
            $prev_string = '';
            if ($level >= 1) {
                for ($i = 1; $i < $level; ++$i) {
                    $prev_string .= '-';
                }
                $prev_string .= ' ';
            }

            foreach ($categories as $category) {
                $categoryTree[$category->id] = $prev_string.$category->getNameAttribute();

                $traverse($categoryTree, $category->children, $fieldname, $level);
            }
        };

        $categories = Category::orderBy('order', 'ASC')->get();

        foreach ($categories as $category) {
            if (!$category->parent_id) {
                $categoryTree[$category->id] = $category->getNameAttribute();

                //all parents
                $traverse($categoryTree, Category::getTree($category->id), 'category_id', $level);
            }
        }

        return  $categoryTree;
    }
}
