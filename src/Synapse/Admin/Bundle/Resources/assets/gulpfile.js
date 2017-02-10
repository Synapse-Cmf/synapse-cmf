var concat = require('gulp-concat');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var gulp = require('gulp');
var merge = require('merge-stream');
var urlAdjuster = require('gulp-css-url-adjuster');

// js concat
gulp.task('js', () => gulp
  .src([
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'node_modules/select2/dist/js/select2.js',
    'node_modules/cropper/dist/cropper.js',
    'node_modules/dropzone/dist/dropzone.js',
    'node_modules/clipboard/dist/clipboard.js',
    'src/js/**/*.js'
  ])
  .pipe(concat('synapse-admin-theme.js'))
  .pipe(gulp.dest('../public/js'))
);
gulp.task('js:watch', function () {
  gulp.watch('src/js/**/*.js', ['js']);
});

// scss
gulp.task('scss', () => {
  return merge(
      gulp.src([
        'node_modules/bootstrap/dist/css/bootstrap.css',
        'node_modules/cropper/dist/cropper.css',
        'node_modules/select2/dist/css/select2.css',
        'node_modules/select2-bootstrap-theme/dist/select2-bootstrap.css'
      ]),
      gulp
        .src([
          'node_modules/dropzone/src/dropzone.scss',
          'src/scss/**/*.scss'
        ])
        .pipe(sass().on('error', sass.logError))
    )
    .pipe(concat('synapse-admin-theme.css'))
    .pipe(gulp.dest('../public/css'))
  ;
});
gulp.task('scss:watch', () => {
  gulp.watch('src/scss/**/*.scss', ['scss']);
});
