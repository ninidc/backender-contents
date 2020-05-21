<?php

namespace Backender\Contents\Console;

use File;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class BuildJsonFileRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backender:route-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate backender routes for javascript.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = [];

        foreach ($this->router->getRoutes() as $route) {
            if (explode('/', $route->uri())[0] == '_backender') {
                $routes[$route->getName()] = $route->uri();
            }
        }

        File::put(__DIR__.'/../Resources/assets/js/routes.json', json_encode($routes, JSON_PRETTY_PRINT));
    }
}
