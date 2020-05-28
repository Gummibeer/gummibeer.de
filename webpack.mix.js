const mix = require('laravel-mix');

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
    .setPublicPath('public')
    .setResourceRoot('resources')
    .sass('resources/scss/app.scss', 'public/css')
    .babel('resources/js/app.js', 'public/js/app.js')
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
;
