var
  gulp  = require('gulp'),
  watch = require('./semantic/tasks/watch'),
  build = require('./semantic/tasks/build')
;

// import task with a custom task name
gulp.task('watch-ui', watch);
gulp.task('build-ui', build);
