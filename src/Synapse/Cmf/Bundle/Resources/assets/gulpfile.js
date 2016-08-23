var concat = require('gulp-concat');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var gulp = require('gulp');
var merge = require('merge-stream');
var urlAdjuster = require('gulp-css-url-adjuster');

// js concat
gulp.task('js', () => gulp
  .src([
    'node_modules/lodash/lodash.js',
    'node_modules/jquery/dist/jquery.js',
    'bower_components/ckeditor/ckeditor.js',
    'bower_components/ckeditor/lang/en.js',
    'bower_components/ckeditor/styles.js',
    'src/js/**/*.js'
  ])
  .pipe(concat('synapse.js'))
  .pipe(gulp.dest('../public/js'))
);
gulp.task('js:watch', function () {
  gulp.watch(['src/js/**/*.js'], ['js']);
});

// scss
gulp.task('scss', () => {
  return merge(
      gulp.src([
        // css here
      ]),
      gulp
        .src(['src/scss/**/*.scss'])
        .pipe(sass().on('error', sass.logError))
    )
    .pipe(concat('synapse.css'))
    .pipe(gulp.dest('../public/css'))
  ;
});
gulp.task('scss:watch', () => {
  gulp.watch('src/scss/**/*.scss', ['scss']);
});

// ckeditor skin
gulp.task('ckeditor_skin', () => {
  return merge(
      gulp.src([
        'bower_components/ckeditor/skins/moono/**/*.png',
        'bower_components/ckeditor/skins/moono/**/*.gif'
      ]),
      gulp
        .src(['bower_components/ckeditor/skins/moono/editor.css'])
        .pipe(urlAdjuster({
          prepend: '/bundles/synapsecmf/vendor/ckeditor/skins/moono/'
        }))
    )
    .pipe(gulp.dest('../public/vendor/ckeditor/skins/moono'))
  ;
});
