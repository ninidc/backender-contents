<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Routing\Controller;


class ArchitectController extends Controller
{
    public function index()
    {
        return view('backender:contents::index');
    }

    public function settings()
    {
        return view('architect::settings');
    }
    
}
