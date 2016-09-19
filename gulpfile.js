/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 构建命令：gulp
 压缩命令：gulp --production
 基于gulpfile.js为根目录指定目录不能加斜杠 如：/public会找不到路径
 **代表该目录下所有文件，是两个*不是一个*
 */
 
var gulp  	   = require('gulp'),
	minifyhtml = require('gulp-minify-html'),
	minifyCss  = require("gulp-minify-css"),
	uglify     = require("gulp-uglify"),
	replace    = require('gulp-replace'),
	gulp_if    = require('gulp-if'),
	imagemin   = require('gulp-imagemin'),
	pngquant   = require('imagemin-pngquant'),
    del		   = require('del');

var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;  //关闭源地图

var h5Css       = 'public/h5_new/css/static/',
    h5Css_v     = 'h5_new/css/static/',
    html_src    = 'resources/views/',
    html_static = 'public/html_static/',
    timestamp   = 'v='+Date.parse(new Date())/1000;

/*
elixir(function(mix) {
   //编译H5 sass
   //mix.sass('h5/*.scss',h5Css+'sass.css');
   
   //合并CSS
	mix.styles([
		'h5/category.css',
        'h5/calculate.css',
    ], 'public/h5_new/css/static/aa.css');
	
	//纯静态HTML页面处理
	mix.task('html_static');
	
	//文件加版本号
	mix.version([h5Css_v+'*.css'],'public/h5_new/css/v_control');
});*/


/*自定义原生gulp任务函数*/

//这些纯静态页面,我脱离了laravel路由,不能使用elixir版本控制
gulp.task('html_static',['cleanForStaticPage'],function(){ //执行任务前先调用cleanForStaticPage函数
    gulp.start('htmlForStaticPage','cssForStaticPage','jsForStaticPage','imgForStaticPage');
});

gulp.task('htmlForStaticPage',function(){
	gulp.src([html_src + 'html_source/**/*.html'])  //该任务的源文件,**代表改目录下的所有目录
	.pipe(replace(/cache_control/g,timestamp))      //控制缓存
	.pipe(minifyhtml())  							//调用该任务的模块,执行
	.pipe(gulp.dest(html_static)); 				    //编译后输出目录路径         
});

gulp.task('cssForStaticPage',function(){
	gulp.src(html_src+'html_source/css/*.css') 
	.pipe(replace(/cache_control/g,timestamp))
    .pipe(minifyCss())  
    .pipe(gulp.dest(html_static+'css'));
 
});

gulp.task('jsForStaticPage',function(){
	gulp.src(html_src+'html_source/js/*.js') 
    .pipe(uglify())  
    .pipe(gulp.dest(html_static+'js'));
 
});

//GIF图片不压缩
function condition(file){
    return !/.*\.gif$/g.test(file.path);
}

gulp.task('imgForStaticPage', function () {
    gulp.src([html_src + 'html_source/img/*.+(png|gif|jpg|ico)'])
		.pipe(gulp_if(condition,imagemin({
		optimizationLevel:7,
		progressive: true,
		interlaced: true,
		svgoPlugins: [{removeViewBox: false}],//不要移除svg的viewbox属性
		use: [pngquant()] //使用pngquant深度压缩png图片的imagemin插件
		})))
    .pipe(gulp.dest(html_static+'img'));
});

gulp.task('cleanForStaticPage', function () {
    del([html_static+'css/*.css',html_static+'js/*.js',html_static+'img'],{force:true})
});


//全站用gulp方法









