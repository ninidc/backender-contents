<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Backender\Contents\Repositories\CategoryRepository;

use Backender\Contents\Http\Requests\Category\CreateCategoryRequest;
use Backender\Contents\Jobs\Category\CreateCategory;

use Backender\Contents\Http\Requests\Category\UpdateCategoryRequest;
use Backender\Contents\Jobs\Category\UpdateCategory;

use Backender\Contents\Http\Requests\Category\DeleteCategoryRequest;
use Backender\Contents\Jobs\Category\DeleteCategory;

use Backender\Contents\Http\Requests\Category\UpdateCategoryOrderRequest;
use Backender\Contents\Jobs\Category\UpdateCategoryOrder;

// Models
use Backender\Contents\Entities\Category;
use Backender\Contents\Entities\Typology;
use Lang;

class CategoryController extends Controller
{

    public function __construct(CategoryRepository $categories) {
        $this->categories = $categories;
    }

    public function index(Request $request)
    {
        return view('architect::categories.index', [
            "typologies" => Typology::all(),
            "categories" => $this->categories->all()
        ]);
    }

    public function data(Request $request)
    {
        return $this->categories->getTree();
    }



    public function show(Category $category, Request $request)
    {
        return view('architect::categories.form', [
            'category' => $category,
             "categories" => $this->categories->getTreeWithHyphens()
        ]);
    }

    public function create(Request $request)
    {
        return view('architect::categories.form', [
                "categories" => $this->categories->getTreeWithHyphens()
            ]);
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $category = dispatch_now(CreateCategory::fromRequest($request));

            if(!$category) {
                throw new \Exception(Lang::get("architect::fields.error"));
            }

            return redirect(route('categories.show', $category))->with('success', Lang::get("architect::fields.success"));
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        return redirect(route('categories.create'))
            ->with('error', $error)
            ->withInput($request->input());
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        try {
            $category = dispatch_now(UpdateCategory::fromRequest($category, $request));

            if(!$category) {
                throw new \Exception(Lang::get("architect::fields.error"));
            }

            return redirect(route('categories.show', $category))->with('success', Lang::get("architect::fields.success"));
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        return redirect(route('categories.create'))
            ->with('error', $error)
            ->withInput($request->input());
    }


    public function updateOrder(UpdateCategoryOrderRequest $request)
  	{

        $result = dispatch_now(UpdateCategoryOrder::fromRequest($request));

        return $result ? response()->json([
            'success' => true,
            'content' => $result
        ]) : response()->json([
            'success' => false
        ], 500);

  	}

    public function delete(Category $category, DeleteCategoryRequest $request)
    {
        return dispatch_now(DeleteCategory::fromRequest($category, $request)) ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }


}
