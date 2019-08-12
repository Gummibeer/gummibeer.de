let mix = require('laravel-mix');
const GoogleFontsPlugin = require('google-fonts-webpack-plugin');

mix
    .less('resources/assets/less/styles.less', 'public/css/styles.min.css')
    .less('resources/assets/less/slides.less', 'public/css/slides.min.css')
    .combine([
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/jquery.bootstrap.min.js',
        './resources/assets/js/jquery.smooth-scroll.min.js',
        './resources/assets/js/jquery.count-to.min.js',
        './resources/assets/js/jquery.masonry.min.js',
        './resources/assets/js/jquery.vectormap.min.js',
        './resources/assets/js/jquery.vectormap.europe_mill.min.js',
        './resources/assets/js/jquery.main.js',
    ], 'public/js/scripts.min.js')
    .combine([
        './resources/assets/js/modernizr.min.js',
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/jquery.deck.core.min.js',
        './resources/assets/js/jquery.slides.js',
    ], 'public/js/slides.min.js')
    .webpackConfig({
        plugins: [
            new GoogleFontsPlugin({
                filename: '/css/fonts.css',
                path: '/fonts/vendor/googlefonts/',
                fonts: [
                    { family: 'Lato', variants: ['300', '400', '700'] },
                    { family: 'Montserrat', variants: ['700'] },
                    { family: 'Raleway', variants: ['400', '700'] }
                ]
            }),
        ],
    })
;
