<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Backender\Contents\Repositories\MediaRepository;

use Backender\Contents\Http\Requests\Media\CreateMediaRequest;
use Backender\Contents\Http\Requests\Media\DeleteMediaRequest;
use Backender\Contents\Http\Requests\Media\UpdateMediaRequest;

use Backender\Contents\Jobs\Media\DeleteMedia;
use Backender\Contents\Jobs\Media\CreateMedia;
use Backender\Contents\Jobs\Media\UpdateMedia;

use Backender\Contents\Entities\Media;
use Lang;
use Session;

class MediaController extends Controller
{

    public function __construct(MediaRepository $medias) {
        $this->medias = $medias;
    }

    public function index()
    {
        return view('backender:contents::medias.index');
    }

    public function data()
    {
        return $this->medias->getDatatable();
    }

    public function store(CreateMediaRequest $request)
    {
        $media = dispatch_now(CreateMedia::fromRequest($request));

        return $media ? response()->json([
            'success' => true,
            'response' => $media
        ]) : response()->json([
            'success' => false
        ], 500);
    }

    public function show($id, Request $request)
    {
        $media = $this->medias->find($id);

        return response()->json([
            'success' => $media ? true : false,
            'media' => $media
        ]);
    }

    public function update(Media $media, UpdateMediaRequest $request)
    {
        if(dispatch_now(UpdateMedia::fromRequest($media, $request))) {
            return response()->json([
                'success' => true,
                'message' => Lang::get("backender:contents::fields.success")
            ]);
        }

        return response()->json([
            'success' => false
        ], 500);
    }

    public function delete($id, Request $request)
    {
        if (dispatch_now(new DeleteMedia($this->medias->find($id)))) {
            return $request->ajax()
                ? response()->json([
                    'success' => true,
                    'message' => Lang::get("backender:contents::fields.success")
                ]) : redirect()->route('admin.content.medias.index');
        }

        return $request->ajax()
            ? response()->json([
                'error' => true,
                'message' => Lang::get("backender:contents::fields.error")
            ], 500)
            : redirect()->route('admin.content.medias.index');
    }

}
