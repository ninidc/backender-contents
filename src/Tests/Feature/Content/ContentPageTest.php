<?php

namespace Backender\Contents\Tests\Feature\Content;

use Backender\Contents\Tests\TestCase;

use Backender\Contents\Repositories\ContentRepository;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\Typology;
use Backender\Contents\Entities\Language;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Page;
use Modules\Extranet\Entities\RouteParameter;
use Modules\Extranet\Entities\ContentLa;

use Backender\Contents\Jobs\Typology\CreateTypology;
use Backender\Contents\Jobs\Typology\UpdateTypology;

use Backender\Contents\Jobs\Content\CreateContent;
use Backender\Contents\Jobs\Content\UpdateContent;
use Backender\Contents\Jobs\Content\DeleteContent;

use Backender\Contents\Jobs\Category\CreateCategory;
use Backender\Contents\Jobs\Category\UpdateCategory;

use Illuminate\Support\Facades\DB;

class ContentPageTest extends TestCase
{

    private $attributes = [

        'page' => [
            'status' => 0,
            'typology_id' => null,
            'is_page' => true,
            'definition' => [],
            'translations' => [
                'es' => true,
                'en' => true,
                'ca' => true,
            ],
            'fields' => [

                [
                    'identifier' => 'title',
                    'type' => 'text',
                    'value' => [
                        'es' => 'Mi pagina (Spanish)',
                        'en' => 'My page (English)',
                        'ca' => 'Mi pagine (Catala)'
                    ]
                ],

                [
                    'identifier' => 'slug',
                    'type' => 'slug',
                    'value' => [
                        'es' => 'mi-pagina-spanish',
                        'en' => 'my-page-english',
                        'ca' => 'mi-pagine-catala'
                    ]
                ],


                [
                    'identifier' => 'description',
                    'type' => 'richtext',
                    'value' => [
                        'es' => 'Lorem ipsum...',
                        'en' => 'Lorem ipsum...',
                        'ca' => 'Lorem ipsum...',
                    ]
                ],
            ]
        ]
    ];

    /*
     *  Create Page
     */
    public function createPage($attributes = null)
    {
        $attributes = $attributes ? $attributes : $this->attributes['page'];

        $attributes['typology_id'] = null;

        return (new CreateContent($attributes))->handle();
    }

    /*
     *  [TEST] Creating page
     */
    public function testCreatePage()
    {
        // 1. Create Page
        $this->createPage();

        // 2. Test if content is created
        $this->assertTrue(Content::first() ? true : false);
    }


    /*
     *  [TEST] When we remove parent page
     */
    public function testRemoveParentPage()
    {
        // 1. Create Page 1
        $page1 = $this->createPage();

        // 2. Create Page 2
        $attributes2 = $this->attributes['page'];
        $attributes2['parent_id'] = $page1->id;
        $page2 = $this->createPage($attributes2);

        // 3. Create Page 3
        $attributes3 = $this->attributes['page'];
        $attributes3['parent_id'] = $page2->id;
        $page3 = $this->createPage($attributes3);

        // 4. Remove page 1
        (new DeleteContent($page2))->handle();

        // 5. Reload page
        $page1 = Content::find(1);
        $page2 = Content::find(2);
        $page3 = Content::find(3);

        // 6. Test page parent_id
        $this->assertTrue($page3->parent_id == $page1->id ? true : false);


        // 5. Test URLS
        // foreach($page2->urls as $url) {
        //     $language = Language::find($url->language_id);
        //
        //     $actual = $url->url;
        //
        //     $excepted = sprintf('/%s/%s',
        //         $language->iso,
        //         $attributes2['fields'][1]['value'][$language->iso]
        //     );
        //
        //     $message = '--> BAD URL  : ' . $actual . ' must be ' . $excepted;
        //
        //     $this->assertSame($excepted, $actual, $message);
        // }

    }


    /*
     *  [TEST] Field contents really remove
     */
    public function testIsRemoveContentRelationed()
    {
        // 1. Create Page 1
        $page1 = $this->createPage();

        $pageId = $page1->id;

        // 2. Create Page 2 with content relation
        $attributes = $this->attributes['page'];
        $attributes['fields'][] = [
            'identifier' => 'content',
            'type' => 'contents',
            'value' => [
                ['id' => $pageId]
            ]
        ];
        $page2 = $this->createPage($attributes);

        // 3. Remove page 1
        (new DeleteContent($page1))->handle();

        // 4. Test page 2 fields
        $page2 = Content::find(2);

        $contentId = $page2->field('content') ? $page2->field('content')->value : null;

        $this->assertNotEquals($pageId, $contentId);
    }

    public function testRemovePage()
    {

        /*
        $attributes = $this->attributes['page'];
        $attributes['fields'][] = [
            'identifier' => 'content',
            'type' => 'contents',
            'value' => []
        ];

        json_decode($attributes)
        */

        $attributes = json_decode('{
          	"parent_id": null,
          	"translations": {
          		"es": true
          	},
          	"status": "1",
          	"category_id": null,
          	"tags": [],
          	"settings": {
          		"htmlClass": null,
          		"pageType": null
          	},
          	"fields": {
          		"title": {
          			"id": 0,
          			"identifier": "title",
          			"value": {
          				"es": "Page de tests"
          			},
          			"name": "Titre",
          			"type": "text",
          			"icon": "fa-font",
          			"settings": {
          				"entryTitle": true
          			}
          		},
          		"slug": {
          			"id": 1,
          			"identifier": "slug",
          			"value": {
          				"es": "accueil-15"
          			},
          			"name": "Lien permanent",
          			"type": "slug",
          			"icon": "fa-link"
          		},
          		"description": {
          			"id": 0,
          			"identifier": "description",
          			"value": {
          				"es": "<p>Page de tests</p>"
          			},
          			"name": "Description",
          			"type": "richtext",
          			"icon": "fa-align-left"
          		}
          	},
          	"is_page": true,
          	"page": [{
          		"type": "row",
          		"settings": {
          			"htmlId": null,
          			"htmlClass": null,
          			"hasContainer": null
          		},
          		"children": [{
          			"type": "col",
          			"settings": {
          				"htmlId": null,
          				"htmlClass": null
          			},
          			"colClass": "col-xs-12",
          			"children": [{
          				"type": "item",
          				"field": {
          					"class": "Modules\\Architect\\Widgets\\Types\\ElementTable",
          					"rules": {
          						"required": null
          					},
          					"label": "ELEMENT_TABLE",
          					"name": "Tableau principaux",
          					"type": "widget",
          					"icon": "fa fa-table",
          					"settings": {
          						"pagination": null,
          						"tableElements": "5",
          						"excel": null
          					},
          					"component": "CommonWidget",
          					"widget": null,
          					"hidden": false,
          					"defaultSettings": null,
          					"identifier": "temp_[0,0,0]",
          					"fieldname": "Tableau principaux",
          					"fields": [{
          						"class": "Modules\\Architect\\Fields\\Types\\Text",
          						"identifier": "title",
          						"type": "text",
          						"name": "Titre",
          						"value": []
          					}, {
          						"class": "Modules\\Architect\\Fields\\Types\\Link",
          						"identifier": "addBtn",
          						"type": "link",
          						"name": "Ajouter Element",
          						"value": null
          					}]
          				}
          			}]
          		}]
          	}],
          	"parameters": []
          }');


        $page = $this->createPage($attributes);

        $pageId = $page->id;

        // Remove page
        (new DeleteContent($page))->handle();

        $this->assertEquals(0, ContentField::where('content_id',$pageId)->count());
        $this->assertEquals(0, Page::where('content_id',$pageId)->count());
        $this->assertEquals(0, Content::where('id',$pageId)->count());
        $this->assertEquals(0, DB::table('contents_languages')->where('content_id',$pageId)->count());
    }

}
