var fs = require('fs');
var gulp = require('gulp');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var googleWebFonts = require('gulp-google-webfonts');

function task_less() {
    return gulp.src('./resources/assets/less/styles.less')
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./public/css'));
}

function task_fonts() {
    return gulp.src(['./node_modules/@fortawesome/fontawesome-pro/webfonts/**/*'])
        .pipe(gulp.dest('public/fonts'));
}

function task_scripts() {
    return gulp.src([
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/jquery.bootstrap.min.js',
        './resources/assets/js/jquery.smooth-scroll.min.js',
        './resources/assets/js/jquery.count-to.min.js',
        './resources/assets/js/jquery.masonry.min.js',
        './resources/assets/js/jquery.vectormap.min.js',
        './resources/assets/js/jquery.vectormap.europe_mill.min.js',
        './resources/assets/js/jquery.main.js',
    ])
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('./public/js'));
}

function task_googlefonts() {
    return gulp.src('./fonts.list')
        .pipe(googleWebFonts({}))
        .pipe(gulp.dest('public/css'));
}

function task_watch() {
    return gulp.watch('./resources/assets/less/**/*.less', ['less']);
}

function touch(callback) {
    fs.writeFile('./.version', Date.now(), callback);
}

exports.less = gulp.parallel(task_less, task_fonts, touch);
exports.scripts = gulp.parallel(task_scripts, touch);
exports.googlefonts = gulp.parallel(task_googlefonts, touch);
exports.watch = task_watch;
exports.default = gulp.parallel(task_less, task_fonts, task_scripts, task_googlefonts, touch);
