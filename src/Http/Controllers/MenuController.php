<?php

namespace Backender\Contents\Http\Controllers;

use App\Http\Controllers\Controller;

use Backender\Contents\Repositories\MenuRepository;

use Auth;
use Session;

use Backender\Contents\Entities\Menu;

use Backender\Contents\Http\Requests\Menu\CreateMenuRequest;
use Backender\Contents\Jobs\Menu\CreateMenu;

use Backender\Contents\Http\Requests\Menu\UpdateMenuRequest;
use Backender\Contents\Jobs\Menu\UpdateMenu;

use Backender\Contents\Http\Requests\Menu\DeleteMenuRequest;
use Backender\Contents\Jobs\Menu\DeleteMenu;

class MenuController extends Controller
{
    public function __construct(MenuRepository $menus)
    {
        $this->menus = $menus;
        //$this->middleware('auth');
    }

    public function index()
    {
        return view('architect::menu.index');
    }

    public function data()
    {
        return $this->menus->getDatatable();
    }

    public function element($id)
    {
        return $this->menus->getElement($id);
    }

    public function elementsTree(Menu $menu)
    {
        return $this->menus->getElementTree($menu);
    }

    public function show($id)
    {
        return view('architect::menu.form', [
            'menu' => $this->menus->find($id)
        ]);
    }

    public function create()
    {
        return view('architect::menu.form');
    }

    public function store(CreateMenuRequest $request)
    {
        $menu = dispatch_now(CreateMenu::fromRequest($request));

        return $menu ? response()->json([
            'success' => true,
            'menu' => $menu
        ]) : response()->json([
            'success' => false
        ], 500);
    }

    public function update(Menu $menu, CreateMenuRequest $request)
    {

        $menu = dispatch_now(UpdateMenu::fromRequest($menu, $request));

        return $menu ? response()->json([
            'success' => true,
            'menu' => $menu
        ]) : response()->json([
            'success' => false
        ], 500);
    }

    public function delete(Menu $menu, DeleteMenuRequest $request)
    {
        return dispatch_now(DeleteMenu::fromRequest($menu, $request)) ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }

}
