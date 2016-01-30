// Requis
var gulp = require('gulp');

// Include plugins
var plugins = require('gulp-load-plugins')(); // tous les plugins de package.json

// Variables de chemins
var source = './client'; // dossier de travail

////////////////////////////////////////////////////////
gulp.task('clean_css', function () {
  return gulp.src(source + '/**/*.css')
    .pipe(plugins.plumber()) // gère les erreurs de Gulp (relance si nécesaire, etc..)
    .pipe(plugins.csscomb()) // réordonne les propriétés CSS
    .pipe(plugins.cssbeautify({indent: '    '})) // Réindente et nettoie les CSS
    .pipe(plugins.autoprefixer()) // Ajoute les préfixes aux propriétés CSS
    .pipe(gulp.dest(source + '/'));
});

gulp.task('clean_js', function () {
  return gulp.src(source + '/**/*.js')
    .pipe(plugins.plumber())
    .pipe(plugins.esformatter({indent: {value: '    '}})) // Réindente et nettoie les JS
    .pipe(gulp.dest(source + '/'));
});

//gulp.task('check_js', ['clean_js'], function () {
//  return gulp.src(source + '/**/*.js')
//    .pipe(plugins.plumber())
//    .pipe(plugins.jshint()) // Vérifie le code JS
//    .pipe(plugins.jshint.reporter('default')); // et retourne les erreurs 
//});

gulp.task('dev', ['clean_css',  'clean_js']);

////////////////////////////////////////////////////////
gulp.task('concat_skin', function () {
  return gulp.src([source + '/skins/reset.css', source + '/skins/defaut/base.css', source + '/skins/defaut/style.css', source + '/skins/defaut/responsive.css', source + '/skins/defaut/font-awesome.css'])  
    .pipe(plugins.plumber())  
    .pipe(plugins.concat('all.css'))
    .pipe(gulp.dest(source + '/skins/defaut'));
});

gulp.task('minify_all_css', ['concat_skin'], function () {
  return gulp.src(source + '/skins/defaut/all.css')
    .pipe(plugins.plumber())  
    .pipe(plugins.csso())
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(source + '/skins/defaut'));
});

gulp.task('prod', ['concat_skin',  'minify_all_css']);