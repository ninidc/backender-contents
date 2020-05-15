<?php

namespace Backender\Contents;

use Config;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BackenderContentProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerFactories();

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        $router->aliasMiddleware('DetectUserLocale', \Backender\Contents\Http\Middleware\DetectUserLocale::class);

        // FIXME : don't know if necesary
        //$this->registerAliases();
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
    }

    public function registerAliases()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $aliases = Config::get('architect.aliases');

            if (is_array($aliases)) {
                foreach ($aliases as $alias => $class) {
                    $loader->alias($alias, $class);
                }
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Backender\Contents\Console\ElasticSearchIndexAllContents::class,
            \Backender\Contents\Console\ElasticSearchBuildsIndexes::class,
            \Backender\Contents\Console\ElasticSearchRemoveAllIndexes::class,
            \Backender\Contents\Console\BuildAllUrls::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/Config/config.php' => config_path('architect.php'),
        ], 'config');

        // Merging configuration
        $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'architect');
        $this->mergeConfigFrom(__DIR__.'/Config/elasticsearch.php', 'architect.elasticsearch');
        $this->mergeConfigFrom(__DIR__.'/Config/images.php', 'images');
        $this->mergeConfigFrom(__DIR__.'/Config/database.php', 'database.connections');
        $this->mergeConfigFrom(__DIR__.'/Config/settings.php', 'settings');
        $this->mergeConfigFrom(__DIR__.'/Config/fonts.php', 'fonts');

        // We really use-it ?
        $this->mergeConfigFrom(__DIR__.'/Config/medias.php', 'medias');
        $this->mergeConfigFrom(__DIR__.'/Config/fields.php', 'fields');
        $this->mergeConfigFrom(__DIR__.'/Config/styles.php', 'styles');

        $this->mergeConfigFrom(__DIR__.'/Config/menu.php', 'architect::menu');

        $this->mergeConfigFrom(
            __DIR__.'/Config/users.php',
            'architect::settings.users'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/architect');

        $sourcePath = __DIR__.'/Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path.'/modules/architect';
        }, \Config::get('view.paths')), [$sourcePath]), 'architect');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/architect');
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'architect');
        } else {
            $this->loadTranslationsFrom(__DIR__.'/Resources/lang', 'architect');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__.'/Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
