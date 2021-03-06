<?php

namespace Backender\Contents\Http\Controllers;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\Tag;
use Backender\Contents\Entities\Typology;
use Backender\Contents\Fields\FieldsReactAdapter;
use Backender\Contents\Fields\FieldsReactPageBuilderAdapter;
use Backender\Contents\Http\Requests\Content\CreateContentRequest;
use Backender\Contents\Http\Requests\Content\DeleteContentRequest;
use Backender\Contents\Http\Requests\Content\DuplicateContentRequest;
use Backender\Contents\Http\Requests\Content\PublishContentRequest;
use Backender\Contents\Jobs\Content\CreateContent;
use Backender\Contents\Jobs\Content\DeleteContent;
use Backender\Contents\Jobs\Content\DuplicateContent;
use Backender\Contents\Jobs\Content\PublishContent;
use Backender\Contents\Jobs\Content\UpdateContent;
use Backender\Contents\Repositories\CategoryRepository;
use Backender\Contents\Repositories\ContentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ContentController extends Controller
{
    /**
     * __construct.
     *
     * @return void
     */
    public function __construct(
        ContentRepository $contents,
        CategoryRepository $categories
    ) {
        $this->contents = $contents;
        $this->categories = $categories;
    }

    /**
     * index.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function index(Request $request)
    {
        return view('backender:contents::contents.index', [
            'typologies' => Typology::all(),
        ]);
    }

    /**
     * data.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function data(Request $request)
    {
        $options = [];

        if ($request->get('typology_id')) {
            $options['where'] = [
                ['typology_id', '=', $request->get('typology_id')],
            ];
        }

        if ($request->get('display_pages')) {
            $options['whereHas'] = [
                'page' => ['content_id', '<>', null],
            ];
        }

        return $this->contents->getDatatable($options);
    }

    /**
     * pagesTree.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function pagesTree(Request $request)
    {
        return $this->contents->getPagesGraph();
    }

    /**
     * modalData.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function modalData(Request $request)
    {
        return $this->contents->getModalDatatable();
    }

    /**
     * show.
     *
     * @param mixed $content
     * @param mixed $request
     *
     * @return void
     */
    public function show(Content $content, Request $request)
    {
        if ($content->typology) {
            $content->typology->load('fields');
        }

        return view('backender:contents::contents.show', [
            'content' => $content->load('tags', 'categories', 'languages'),
            'typology' => $content->typology,
            'fields' => $content->typology ? (new FieldsReactAdapter($content))->get() : null,
            'page' => $content->is_page ? (new FieldsReactPageBuilderAdapter($content))->get() : null,
            'settings' => $content->settings,
            'pages' => $this->contents->getTreeWithHyphens(),
            'tags' => Tag::all(),
            'categories' => $this->categories->getTree(),
        ]);
    }

    /**
     * create.
     *
     * @param mixed $typology
     * @param mixed $request
     *
     * @return void
     */
    public function create(Typology $typology = null, Request $request)
    {
        return view('backender:contents::contents.show', [
            'typology' => $typology != null ? $typology->load('fields') : null,
            'fields' => $typology != null ? (new FieldsReactAdapter($typology))->get() : null,
            'page' => null,
            'settings' => null,
            'pages' => $this->contents->getTreeWithHyphens(),
            'tags' => Tag::all(),
            'categories' => $this->categories->getTree(),
        ]);
    }

    /**
     * store.
     *
     * @param mixed $request
     *
     * @return void
     */
    public function store(CreateContentRequest $request)
    {
        $content = dispatch_now(CreateContent::fromRequest($request));

        return $content ? response()->json([
            'success' => true,
            'content' => $content,
        ]) : response()->json([
            'success' => false,
        ], 500);
    }

    /**
     * publish.
     *
     * @param mixed $content
     * @param mixed $request
     *
     * @return void
     */
    public function publish(Content $content, PublishContentRequest $request)
    {
        if (dispatch_now(PublishContent::fromRequest($content, $request))) {
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ], 500);
    }

    /**
     * update.
     *
     * @param mixed $content
     * @param mixed $request
     *
     * @return void
     */
    public function update(Content $content, CreateContentRequest $request)
    {
        $content = dispatch_now(UpdateContent::fromRequest($content, $request));

        return $content ? response()->json([
            'success' => true,
            'content' => $content,
        ]) : response()->json([
            'success' => false,
        ], 500);
    }

    /**
     * delete.
     *
     * @param mixed $content
     * @param mixed $request
     *
     * @return void
     */
    public function delete(Content $content, DeleteContentRequest $request)
    {
        return dispatch_now(DeleteContent::fromRequest($content, $request)) ? response()->json([
            'success' => true,
        ]) : response()->json([
            'success' => false,
        ], 500);
    }

    /**
     * duplicate.
     *
     * @param mixed $content
     * @param mixed $request
     *
     * @return void
     */
    public function duplicate(Content $content, DuplicateContentRequest $request)
    {
        $content = dispatch_now(DuplicateContent::fromRequest($content, $request));

        return $content ? response()->json([
            'success' => true,
            'content' => $content,
        ]) : response()->json([
            'success' => false,
        ], 500);
    }
}
