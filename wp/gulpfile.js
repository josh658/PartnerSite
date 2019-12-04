var gulp = require('gulp'),
settings = require('./settings'),
webpack = require('webpack'),
browserSync = require('browser-sync').create(),
postcss = require('gulp-postcss'),
rgba = require('postcss-hexrgba'),
autoprefixer = require('autoprefixer'),
cssvars = require('postcss-simple-vars'),
nested = require('postcss-nested'),
cssImport = require('postcss-import'),
mixins = require('postcss-mixins'),
colorFunctions = require('postcss-color-function'),
sass = require('gulp-sass');

gulp.task('sass', function() {
  return gulp.src(settings.themeLocation + 'css/style.scss')
    .pipe(sass()) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest(settings.themeLocation + './css'))
});

gulp.task('styles', function() {
  return gulp.src(settings.themeLocation + 'css/style.css')
    .pipe(postcss([cssImport, mixins, cssvars, nested, rgba, colorFunctions, autoprefixer]))
    .on('error', (error) => console.log(error.toString()))
    .pipe(gulp.dest(settings.themeLocation));
});

gulp.task('scripts', function(callback) {
  webpack(require('./webpack.config.js'), function(err, stats) {
    if (err) {
      console.log(err.toString());
    }

    console.log(stats.toString());
    callback();
  });
});

gulp.task('watch', function(done) {
  browserSync.init({
    notify: false,
    proxy: settings.urlToPreview,
    ghostMode: false
  });

  gulp.watch('./**/*.php', function(done) {
    browserSync.reload();
    done();
  });
  gulp.watch(settings.themeLocation + 'css/**/*.css', gulp.parallel('waitForStyles'));
  gulp.watch([settings.themeLocation + 'js/modules/*.js', settings.themeLocation + 'js/modules/*/*.js', settings.themeLocation + 'js/scripts.js'], gulp.parallel('waitForScripts'));
  gulp.watch([settings.themeLocation + 'css/style.scss', settings.themeLocation + 'css/modules/*.scss'], gulp.parallel('waitForSass'));
  done();
});

//DID NOT WORK
//gulp.task('sass:watch', function(){ gulp.watch(settings.themeLocation + 'css/style.scss', ['sass']);});

gulp.task('waitForSass', gulp.series('sass', function(){
  return gulp.src(settings.themeLocation + 'css/style.scss')
    .pipe(browserSync.stream());
}))

gulp.task('waitForStyles', gulp.series('styles', function() {
  return gulp.src(settings.themeLocation + 'style.css')
    .pipe(browserSync.stream());
}))

gulp.task('waitForScripts', gulp.series('scripts', function(cb) {
  browserSync.reload();
  cb()
}))