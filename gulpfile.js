var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var sourcemaps = require('gulp-sourcemaps');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var concat = require('gulp-concat');

gulp.task('default', ['watch']);

gulp.task('less', function () {
    return gulp.src('./resources/assets/less/styles.less')
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('scripts', function() {
    return gulp.src([
        './resources/assets/js/jquery.min.js',
        './resources/assets/js/jquery.bootstrap.min.js',
        './resources/assets/js/jquery.smooth-scroll.min.js',
        './resources/assets/js/jquery.count-to.min.js',
        './resources/assets/js/jquery.masonry.min.js',
        './resources/assets/js/webfont.min.js',
        './resources/assets/js/jquery.main.js'
    ])
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function () {
    gulp.watch('./resources/assets/less/**/*.less', ['less']);
});