<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Backender\Contents\Repositories\PageLayoutRepository;

// Jobs & Requests
use Backender\Contents\Http\Requests\PageLayout\SavePageLayoutRequest;
use Backender\Contents\Jobs\PageLayout\SavePageLayout;

use Backender\Contents\Http\Requests\PageLayout\DeletePageLayoutRequest;
use Backender\Contents\Jobs\PageLayout\DeletePageLayout;

// Models
use Backender\Contents\Entities\PageLayout;


class PageLayoutController extends Controller
{
    public function __construct(PageLayoutRepository $pageLayouts) {
        $this->pageLayouts = $pageLayouts;
    }

    public function index(Request $request)
    {
        return view('architect::pagelayouts.index');
    }

    public function data(Request $request)
    {
        return $this->pageLayouts->getDatatable();
    }

    public function modalData(Request $request)
    {
        return $this->pageLayouts->getModalDatatable();
    }

    public function show(PageLayout $pageLayout, Request $request)
    {
        return response()->json($pageLayout);
    }

    public function store(SavePageLayoutRequest $request)
    {
        return dispatch_now(SavePageLayout::fromRequest($request)) ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }

    public function delete(PageLayout $pageLayout, DeletePageLayoutRequest $request)
    {
        return dispatch_now(DeletePageLayout::fromRequest($pageLayout, $request)) ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }
}
