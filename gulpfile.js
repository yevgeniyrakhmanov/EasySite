var	syntax			= 'sass'; // Syntax: sass or scss;

var	gulp			= require('gulp'),
	gutil			= require('gulp-util' ),
	sass			= require('gulp-sass'),
	browserSync		= require('browser-sync'),
	concat			= require('gulp-concat'),
	uglify			= require('gulp-uglify'),
	cleancss		= require('gulp-clean-css'),
	rename			= require('gulp-rename'),
	autoprefixer	= require('gulp-autoprefixer'),
	notify			= require('gulp-notify'),
	del				= require('del'),
	imagemin		= require('gulp-imagemin'),
	cache			= require('gulp-cache');

gulp.task('browser-sync', function() {
	browserSync({
		proxy: 'easysite',
		//browser: 'chrome',
		notify: false,
	});
});

gulp.task('styles', function() {
	return gulp.src('app/'+syntax+'/**/*.'+syntax+'')
	.pipe(sass({ outputStyle: 'expanded' }).on("error", notify.onError()))
	.pipe(rename({ suffix: '.min', prefix : '' }))
	.pipe(autoprefixer(['last 15 versions']))
	// .pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
	.pipe(gulp.dest('app/css'))
	.pipe(browserSync.stream())
});

gulp.task('scripts', function() {
	return gulp.src([
		'app/libs/jquery/dist/jquery.min.js',
		'app/libs/bootstrap/js/bootstrap.min.js',
		'app/js/common.js', // Always at the end
		])
	.pipe(concat('scripts.min.js'))
	// .pipe(uglify()) // Mifify js (opt.)
	.pipe(gulp.dest('app/js'))
	.pipe(browserSync.reload({ stream: true }))
});

gulp.task('code', function() {
	return gulp.src('app/**/*.php')
	.pipe(browserSync.reload({ stream: true }))
});

gulp.task('watch', function() {
	gulp.watch('app/'+syntax+'/**/*.'+syntax+'', gulp.parallel('styles'));
	gulp.watch(['libs/**/*.js', 'app/js/common.js'], gulp.parallel('scripts'));
	gulp.watch('app/**/*.php', gulp.parallel('code'))
});

// Build Production Site
gulp.task('build-dist', function(done) {

	var buildFiles = gulp.src([
		'app/**/*.php', 
		'app/*.php',
		'app/.htaccess',
		]).pipe(gulp.dest('dist'));

	var buildCss = gulp.src([
		'app/css/main.min.css',
		]).pipe(gulp.dest('dist/css'));

	var buildJs = gulp.src([
		'app/js/scripts.min.js',
		]).pipe(gulp.dest('dist/js'));

	var buildFonts = gulp.src([
		'app/fonts/**/*',
		]).pipe(gulp.dest('dist/fonts'));

	done();

});

gulp.task('imagemin', function() {
	return gulp.src('app/img/**/*')
	.pipe(cache(imagemin())) // Cache Images
	.pipe(gulp.dest('dist/img')); 
});

// Cleaning Production distributive
gulp.task('clean', function(done) {
  del.sync('dist');
  done();
});
 
// Clear Cache
gulp.task('clear', function() {
  return cache.clearAll();
});

gulp.task('build', gulp.series('clear', 'clean', 'imagemin', 'styles', 'scripts', 'build-dist'));

gulp.task('default', gulp.parallel('styles', 'scripts', 'browser-sync', 'watch'));
