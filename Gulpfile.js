var
    gulp = require('gulp'),
    watch = require('./semantic/tasks/watch'),
    build = require('./semantic/tasks/build'),

    less = require('gulp-less')
    concat = require('gulp-concat')
    livereload = require('gulp-livereload')
;

var
    paths = {
        'css': [
            './src/Bundle/*/Resources/private/less/*.less',
        ],
        'js': [
            'node_modules/jquery/dist/jquery.min.js',
            './src/Bundle/*/Resources/private/js/*.js',
        ],
    }


gulp.task('build-css', function () {
    return gulp.src(paths.css)
    .pipe(less())
    .pipe(concat('admin.css'))
    .pipe(gulp.dest('web/assets'));
});

gulp.task('build-js', function () {
    return gulp.src(paths.js)
    .pipe(concat('admin.js'))
    .pipe(gulp.dest('web/assets'));
});

// import task with a custom task name
gulp.task('watch-ui', watch);
gulp.task('build-ui', build);

gulp.task('build', ['build-css', 'build-js']);

gulp.task('watch', function () {
    livereload.listen();

    gulp.watch(paths.js, ['build-js']);
    gulp.watch(paths.css, ['build-css']);
});
