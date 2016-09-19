var del = require('del'),
    gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    concat = require('gulp-concat'),
    changed = require('gulp-changed'),
    fileinclude = require('gulp-file-include'),  //https://segmentfault.com/a/1190000003043326
    gif = require('gulp-if'),
    minifyhtml = require('gulp-minify-html'),
    imagemin = require('gulp-imagemin'),
    livereload = require('gulp-livereload'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    replace = require('gulp-replace'),
    rev = require('gulp-rev-uyes'),
    revCollector = require('gulp-rev-collector-uyes'),
    sass = require('gulp-sass'),
    spriter = require('gulp-css-spriter-retina'),
    transport = require("gulp-seajs-transport"),
    uglify = require('gulp-uglify');

var src = 'html_source/',
    dest = 'static/',
    dev = false,
    now = 'v=' + +new Date();

// gif文件不压缩
function condition(file){
    return !/.*\.gif$/g.test(file.path);
}
// 过滤图片文件
function conditionMedia(file){
    return !/.*\.(png|gif|jpg|ico|mp3)$/g.test(file.path);
}

gulp.task('build', ['clean'], function () {
    gulp.start('revCollector');
});

gulp.task('test', function () {
    dev = true;
    gulp.start('sass','html','html_active');
});

// html
gulp.task('html', function () {
    return gulp.src([src + '**/*.html', '!' + src + 'common/*.html'])
//        .pipe(gif(dev,changed( dest )))
        .pipe(fileinclude({
            prefix: '<!--@@',
            basepath: '@file',
            suffix: '-->'
        }))
        .pipe(minifyhtml({
            quotes: true
        }))
        .pipe(replace(/{AABBCC}/g, now))
        .pipe(gif(!dev,replace('html_source', 'static')))
        .pipe(gulp.dest(dest));
});

// html_active
gulp.task('html_active', function () {
    return gulp.src(['html_act/**/*.*'])
        .pipe(gif(conditionMedia, fileinclude({
            prefix: '<!--@@',
            basepath: '@file',
            suffix: '-->'
        })))
        .pipe(gif(conditionMedia, replace(/{AABBCC}/g, now)))
        .pipe(gulp.dest('act_static'));
});

// js
gulp.task('js', function () {
    return gulp.src([src + 'assets/js/**/*.js'])
        .pipe(replace(/{AABBCC}/g, now))
        .pipe(uglify().on('error', function(e){
            console.log(e);
        }))
        .pipe(rev())
        .pipe(gulp.dest(dest + 'assets/js/'))
        .pipe(rev.manifest())
        .pipe(gulp.dest(dest + 'assets/js'));

});

// transport
gulp.task("transport", function () {
    gulp.src(src + '/assets/js/page/*.js', {
            base: src + '/assets/js/'
        })
        .pipe(transport())
        .pipe(gulp.dest(src + '/assets/js'));
});

// image
gulp.task('image', function () {
    return gulp.src([src + 'assets/images/upload/*.+(png|gif|jpg|ico)'])
        .pipe(gif(condition,imagemin({
            optimizationLevel: 3,
            progressive: true,
            interlaced: true
        })))
        .pipe(gulp.dest(dest + 'assets/images/upload'));
});

// imageRev
gulp.task('imagerev',['image','css'], function () {
    return gulp.src([src + 'assets/images/*.+(png|gif|jpg|ico)',dest + 'assets/images/icons.png'])
        .pipe(gif(condition,imagemin({
            optimizationLevel: 3,
            progressive: true,
            interlaced: true
        })))
        .pipe(rev())
        .pipe(gulp.dest(dest + 'assets/images'))
        .pipe(rev.manifest())
        .pipe(gulp.dest(dest + 'assets/images'));
});

// css
gulp.task('css', ['sass'], function () {
    return gulp.src([src + '**/*.css'])
        .pipe(gif(dev,changed( dest )))
        .pipe(rev())
        .pipe(spriter({
             'spriteSheet': 'static/assets/images/icons.png',
             'pathToSpriteSheetFromCSS': '/static/assets/images/icons.png',
             'scale' : 0.5,
             'spritesmithOptions': {
                padding: 10
             }
        }))
        .pipe(minifycss())
        .pipe(gulp.dest(dest))
        .pipe(rev.manifest())
        .pipe(gulp.dest(dest + 'assets/css'));
});

// sass
gulp.task('sass', function () {
    return gulp.src([src + 'assets/css/sass/*.+(css|scss)'])
        .pipe(sass({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(gulp.dest(src + 'assets/css/'));
});

// revCollector
gulp.task('revCollector', ['js', 'html', 'html_active', 'imagerev'], function(){
    return gulp.src([ dest + '**/rev-manifest.json', dest + '**/*.+(html|js|css)'])
        .pipe( revCollector() )
        .pipe( gulp.dest(dest) );
});

gulp.task('clean', function (cb) {
    del([dest + '**','act_static/**'], {
        force: true
    }, cb)
});

gulp.task('watch', function () {
    gulp.watch([src + '**','html_act/**'], ['test']);
});