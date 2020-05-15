<?php

namespace Backender\Contents\Jobs\Content;

use Backender\Contents\Http\Requests\Content\DeleteContentRequest;
use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\ContentField;
use Backender\Contents\Entities\Page;
use Modules\Extranet\Entities\RouteParameter;

use Illuminate\Support\Facades\Schema;

use Backender\Contents\Tasks\Urls\UpdateUrlsContent;
use Illuminate\Support\Facades\DB;

class DeleteContent
{
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public static function fromRequest(Content $content, DeleteContentRequest $request)
    {
        return new self($content);
    }

    public function handle()
    {
        // Disable FK constraints for this operation
        Schema::disableForeignKeyConstraints();

        // Unindex content (Elasticsearch)
        $this->content->unindex();

        // Update parent ID of childrens
        $contents = Content::where('parent_id', $this->content->id)->get();

        // Update URLS of the contents
        if($contents->isNotEmpty()) {
            foreach($contents as $content) {
                $content->update([
                    'parent_id' => $this->content->parent_id
                ]);

                (new UpdateUrlsContent($content))->run();
            }
        }

        // Remove contents fields relation
        ContentField::where('relation', 'contents')
            ->where('value', $this->content->id)
            ->delete();

        // Delete content fields
        ContentField::where('content_id', $this->content->id)->delete();
        Page::where('content_id', $this->content->id)->delete();

        DB::table('contents_routes_parameters')->where('content_id',$this->content->id)->delete();
        DB::table('contents_languages')->where('content_id',$this->content->id)->delete();
        DB::table('contents_categories')->where('content_id',$this->content->id)->delete();
        DB::table('contents_tags')->where('content_id',$this->content->id)->delete();
        DB::table('urls')
          ->where('entity_id',$this->content->id)
          ->where('entity_type','Backender\Contents\Entities\Content')
          ->delete();

        // Delete content
        $raws = Content::where('id', $this->content->id)->delete();

        // Enable FK constraints
        Schema::enableForeignKeyConstraints();

        return $raws;
    }
}
