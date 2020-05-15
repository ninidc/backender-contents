<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;

// Models
use Backender\Contents\Entities\Typology;

// Create
use Backender\Contents\Http\Requests\Typology\CreateTypologyRequest;
use Backender\Contents\Jobs\Typology\CreateTypology;

// Update
use Backender\Contents\Http\Requests\Typology\UpdateTypologyRequest;
use Backender\Contents\Jobs\Typology\UpdateTypology;

// Delete
use Backender\Contents\Http\Requests\Typology\DeleteTypologyRequest;
use Backender\Contents\Jobs\Typology\DeleteTypology;


class TypologyController extends Controller
{
    public function index()
    {
        return view('architect::typologies.index', [
            "typologies" => Typology::all()
        ]);
    }

    public function create()
    {
        return view('architect::typologies.form');
    }

    public function show(Typology $typology)
    {
        return view('architect::typologies.form', [
            'typology' => $typology->load('fields', 'attrs')
        ]);
    }

    public function store(CreateTypologyRequest $request)
    {
        $typology = dispatch_now(CreateTypology::fromRequest($request));

        return $typology ? response()->json([
            'success' => true,
            'typology' => $typology
        ]) : response()->json([
            'success' => false
        ], 500);
    }

    public function update(Typology $typology, UpdateTypologyRequest $request)
    {
        $typology = dispatch_now(UpdateTypology::fromRequest($typology, $request));

        return $typology ? response()->json([
            'success' => true,
            'typology' => $typology
        ]) : response()->json([
            'success' => false
        ], 500);
    }


    public function delete(Typology $typology, DeleteTypologyRequest $request)
    {
        $typology = dispatch_now(DeleteTypology::fromRequest($typology, $request));

        return $typology ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }
}
