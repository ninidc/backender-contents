<?php

namespace Backender\Contents\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Backender\Contents\Entities\Content;
use Backender\Contents\Entities\Typology;
use Backender\Contents\Entities\Category;

use Backender\Contents\Tasks\Urls\UpdateUrlsTypology;
use Backender\Contents\Tasks\Urls\UpdateUrlsCategory;
use Backender\Contents\Tasks\Urls\UpdateUrlsContent;

use DB;

class BuildAllUrls extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'architect:builds-all-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds all urls of content';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('urls')->delete();

        Typology::all()->map(function($typology){
            (new UpdateUrlsTypology($typology))->run();
        });

        Category::all()->map(function($category){
            (new UpdateUrlsCategory($category))->run();
        });

        Content::all()->map(function($content){
            (new UpdateUrlsContent($content))->run();
        });
    }

}
