var gulp=require('gulp');
var cucumber=require('gulp-cucumber');
var argv=require('yargs').argv;
var run = require('gulp-run');
var file;
var folder;
var directory;

gulp.task('Json',function(){
	return run('cucumber --format json_pretty features/'+argv.folder+'/*.feature -o report/'+argv.directory+'/'+argv.folder+'.json').exec();
});

gulp.task('PRDXN-ITTT', ['Json'], function(){
	return gulp.src('*features/'+argv.folder+'/*.feature').pipe(cucumber({
		'steps': '*features/step_definitions/'+argv.folder+'/*.js',
		'support': '*features/support/*.js',
		'format': 'pretty'
	}));
});

// gulp.task('watch',function(){
//     gulp.watch('*features/**/*.{js,feature}',['cucumber']);
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
