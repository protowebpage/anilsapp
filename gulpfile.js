const elixir = require('laravel-elixir');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

const	vendorJS = [
		'./resources/assets/bower_components/jquery/dist/jquery.min.js',
		'./resources/assets/bower_components/bootstrap/dist/js/bootstrap.min.js',
		'./resources/assets/bower_components/dropzone/dist/min/dropzone.min.js',
		'./resources/assets/bower_components/toastr/toastr.min.js',
		'./resources/assets/bower_components/bootbox.js/bootbox.js'
	],
	vendorCSS = [
		// './resources/assets/bower_components/bootstrap/dist/css/bootstrap.min.css',
		'./resources/assets/css/bootstrap.css',
		'./resources/assets/bower_components/dropzone/dist/min/dropzone.min.css',
		'./resources/assets/bower_components/toastr/toastr.min.css'
	];


// require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.sass('app.scss');
	mix.scripts('app.js', 'public/js/app.js');
	mix.scripts('backend.js', 'public/js/backend.js');
	mix.version(['js/app.js', 'js/backend.js','css/app.css', 'css/vendor.css']);
});


// Mix vendor styles ans scripts
gulp.task('vendor', function () {
  gulp.src(vendorJS)
    .pipe(concat('vendor.js'))
    // .pipe(uglify())
    .pipe(gulp.dest('./public/js'));

  gulp.src(vendorCSS)
    .pipe(concat('vendor.css'))
    .pipe(gulp.dest('./public/css'));

});
