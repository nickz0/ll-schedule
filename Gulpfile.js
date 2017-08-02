var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    gulp.src('./app/Resources/frontend/css/stylesheet.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(gulp.dest('./web/assets/css'));
});

gulp.task('js', function() {
    gulp.src('./app/Resources/frontend/js/*.js')
        .pipe(gulp.dest('./web/assets/js'));
});

gulp.task('default', ['sass', 'js']);