<<<<<<< HEAD
var gulp=require('gulp');
var cucumber=require('gulp-cucumber');
var argv=require('yargs').argv;
var run = require('gulp-run');
var file;
var folder;

// gulp.task('Json',function(){
// 	return run('cucumberjs features/'+argv.folder+'/*.feature -f json:report/cucumber_report.json').exec();
// });

gulp.task('PRDXN-ITTT',function(){
	return gulp.src('*features/'+argv.folder+'/*.feature').pipe(cucumber({
		'steps': '*features/step_definitions/'+argv.folder+'/*.js',
		'support': '*features/support/*.js',
		'format': 'pretty'
	}));
});

// gulp.task('watch',function(){
// 	gulp.watch('*features/**/*.{js,feature}',['cucumber']);
// });

gulp.task('default',['PRDXN-ITTT']);
// var elixir = require('laravel-elixir');


//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |


//  elixir(function(mix) {
//  	mix.sass('app.scss');
//  });
=======
var elixir = require('laravel-elixir');

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
});
>>>>>>> 2745d2ca41be357ef21772383fa816330fac3fea
