<?php

namespace Backender\Contents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;


use Backender\Contents\Repositories\LanguageRepository;

use Backender\Contents\Http\Requests\Language\CreateLanguageRequest;
use Backender\Contents\Jobs\Language\CreateLanguage;

use Backender\Contents\Http\Requests\Language\UpdateLanguageRequest;
use Backender\Contents\Jobs\Language\UpdateLanguage;

use Backender\Contents\Http\Requests\Language\DeleteLanguageRequest;
use Backender\Contents\Jobs\Language\DeleteLanguage;

// Models
use Backender\Contents\Entities\Language;
use Lang;

class LanguageController extends Controller
{

    public function __construct(LanguageRepository $languages) {
        $this->languages = $languages;
    }

    public function index(Request $request)
    {
        return view('architect::languages.index', [
            "languages" => $this->languages->all()
        ]);
    }

    public function data(Request $request)
    {
        return $this->languages->getDatatable();
    }

    public function show(Language $language, Request $request)
    {
        return view('architect::languages.form', [
            'language' => $language,
        ]);
    }

    public function create(Request $request)
    {
        return view('architect::languages.form');
    }

    public function store(CreateLanguageRequest $request)
    {
        try {
            $language = dispatch_now(CreateLanguage::fromRequest($request));

            if(!$language) {
                throw new \Exception(Lang::get("architect::fields.error"));
            }

            return redirect(route('languages.show', $language))->with('success', Lang::get("architect::fields.success"));
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        return redirect(route('languages.create'))->with('error', $error);
    }

    public function update(Language $language, UpdateLanguageRequest $request)
    {
        try {
            $language = dispatch_now(UpdateLanguage::fromRequest($language, $request));

            if(!$language) {
                throw new \Exception(Lang::get("architect::fields.error"));
            }

            return redirect(route('languages.show', $language))->with('success', Lang::get("architect::fields.success"));
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        return redirect(route('languages.show', $language))->with('error', $error);
    }


    public function delete(Language $language, DeleteLanguageRequest $request)
    {
        return dispatch_now(DeleteLanguage::fromRequest($language, $request)) ? response()->json([
            'success' => true
        ]) : response()->json([
            'success' => false
        ], 500);
    }

}
