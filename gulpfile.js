var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var sourcemaps = require('gulp-sourcemaps');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var concat = require('gulp-concat');

gulp.task('default', ['watch']);

gulp.task('less', function () {
    return gulp.src('./assets/less/styles.less')
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('scripts', function() {
    return gulp.src([
        './assets/js/jquery.min.js',
        './assets/js/jquery.bootstrap.min.js',
        './assets/js/jquery.smooth-scroll.min.js',
        './assets/js/jquery.count-to.min.js',
        './assets/js/jquery.masonry.min.js',
        // './assets/js/jquery.owl.carousel.min.js',
        './assets/js/webfont.min.js',
        './assets/js/jquery.main.js'
    ])
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function () {
    gulp.watch('./assets/less/**/*.less', ['less']);
});