const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');

require('laravel-mix-merge-manifest');

mix
    .options({ 
        processCssUrls: false 
    })
    .setPublicPath('./public')
    .mergeManifest();


// ---------------------------------------- //
//      LANGUAGES
// ---------------------------------------- //
mix.webpackConfig({
    plugins: [
        new WebpackShellPlugin({
            onBuildStart: [
                'php ../../../../artisan lang:js ./public/js/lang.dist.js -s Resources/lang',
                'php ../../../../artisan lang:js ./public/js/lang.json -s Resources/lang --json',
            ],
            onBuildEnd: []
        })
    ]
});
// ---------------------------------------- //


// ---------------------------------------- //
//      COMPILE ASSETS
// ---------------------------------------- //
mix.react('Resources/assets/js/app.js', './public/js')
    .sass('Resources/assets/sass/architect/app.scss', './public/css')
    .scripts([
        'Resources/assets/js/architect/architect.js',
        'Resources/assets/js/architect/architect.dialog.js',
        'Resources/assets/js/architect/architect.medias.js',
        'Resources/assets/js/architect/architect.contents.js',
        'Resources/assets/js/architect/architect.tags.js',
        'Resources/assets/js/architect/architect.users.js',
        'Resources/assets/js/architect/architect.pageLayouts.js',
        'Resources/assets/js/architect/architect.menu.js',
        'Resources/assets/js/architect/architect.languages.js',
        'Resources/assets/js/architect/architect.translations.js'
    ], './public/js/contents.js');
// ---------------------------------------- //


if (mix.inProduction()) {
    mix.version();
}
