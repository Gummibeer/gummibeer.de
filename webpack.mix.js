const mix = require('laravel-mix');
require('laravel-mix-sri');
require('laravel-mix-purgecss');
const glob = require('glob');
const path = require('path');

Mix.listen('configReady', webpackConfig => {
    webpackConfig.module.rules.forEach(rule => {
        if (Array.isArray(rule.use)) {
            rule.use.forEach(ruleUse => {
                if (ruleUse.loader === 'resolve-url-loader') {
                    ruleUse.options.engine = 'postcss';
                }
            });
        }
    });
});

mix
    .sass('resources/scss/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .options({
        processCssUrls: true,
        postCss: [
            require('tailwindcss')('./tailwind.config.js'),
            require('postcss-discard-comments')({
                removeAll: true,
            }),
        ],
    })
    .version()
    .generateIntegrityHash({
        enabled: true,
    })
    .purgeCss({
        content: [
            './resources/views/**/*.blade.php',
        ],
        whitelist: [
            // resources/content/jobs
            'fal',
            'fa-ribbon',
            'fa-briefcase',
            'fa-graduation-cap',
        ],
    })
;

glob.sync(path.resolve(__dirname, 'resources', 'images') + '/**/*.@(png|jpg)').forEach(img => {
    mix.copy(img, img.replace(path.resolve(__dirname, 'resources', 'images'), 'public/images'));
});