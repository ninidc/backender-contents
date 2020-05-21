<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Routing\Controller;

class BackenderController extends Controller
{
    public function index()
    {
        return view('backender:contents::index');
    }

    public function settings()
    {
        return view('backender:contents::settings');
    }
}
