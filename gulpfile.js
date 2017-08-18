'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');

var sourceDir = 'scss/';
var destDir = 'css/';

 // css source file: .scss files
var css = {
    in: sourceDir,
    out: destDir,
    watch: sourceDir,
    sassOpts: {
        outputStyle: 'compressed',
        errLogToConsole: true
    }
};

// compile scss
gulp.task('sass-conversion', function () {
    return gulp.src(css.in + 'main.scss')
        .pipe(sass(css.sassOpts))
        .pipe(rename("main.css"))
        .pipe(gulp.dest(css.out));
});

/* styles */
gulp.task('styles', ['sass-conversion'], function () {
 // return gulp.src(['dashboard/common/css/dashboard']).pipe(gulp.dest('public/common'));
});

/* default */
gulp.task('default', function () {
  gulp.start('styles');
});


gulp.task('sass', function () {
  return gulp.src('./css/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

gulp.task('watch', function () {
  gulp.watch('./scss/*.scss', ['styles']);
});
