var
    gulp = require('gulp'),
    less = require('gulp-less')
    concat = require('gulp-concat')
    livereload = require('gulp-livereload')
    addSrc = require('gulp-add-src')
;

var
    paths = {
        'css': [
            './node_modules/semantic-ui-css/semantic.min.css'
        ],
        'less': [
            './src/Bundle/*/Resources/private/less/*.less',
        ],
        'js': [
            './node_modules/jquery/dist/jquery.min.js',
            './node_modules/semantic-ui-css/semantic.min.js',
            './src/Bundle/*/Resources/private/js/*.js',
        ]
    }


gulp.task('build-css', function () {
    gulp.src(paths.less)
        .pipe(less())
        .pipe(addSrc(paths.css))
        .pipe(concat('admin.css'))
        .pipe(gulp.dest('web/assets'));

    gulp.src([
        'node_modules/semantic-ui-css/themes/**/*'
    ]).pipe(gulp.dest('web/assets/themes/'));
});

gulp.task('build-js', function () {
    return gulp.src(paths.js)
    .pipe(concat('admin.js'))
    .pipe(gulp.dest('web/assets'));
});

gulp.task('build', ['build-css', 'build-js']);

gulp.task('watch', function () {
    livereload.listen();

    gulp.watch(paths.less, ['build-css']);
    gulp.watch(paths.js, ['build-js']);
    gulp.watch(paths.css, ['build-css']);
});
