<?php

namespace Backender\Contents\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ElasticSearchBuildsIndexes extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'architect:elasticsearch-builds-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds all indexes for architect contents';

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
        //
    }

}
