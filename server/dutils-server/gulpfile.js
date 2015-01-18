var gulp = require('gulp');
var gutil = require('gulp-util');
var webpack = require("webpack");
var coffeelint = require('gulp-coffeelint');
var livereload = require('gulp-livereload');

var webpackConfig = require("./webpack.config.js");
var baseClientPath = "./src/Morenware/DutilsBundle/Resources/client";

gulp.task('coffeelint', function () {
    gulp.src(baseClientPath + "/**/*.coffee")
        .pipe(coffeelint())
        .pipe(coffeelint.reporter());
});

gulp.task("dev", ["coffeelint", "webpack-dev"], function() {
    livereload.listen();
    gulp.watch([baseClientPath + "/**/*"], ["coffeelint", "webpack-dev", "all-livereload"]);
});

// modify some webpack config options
var myDevConfig = Object.create(webpackConfig);
myDevConfig.devtool = "sourcemap";
myDevConfig.debug = true;

// create a single instance of the compiler to allow caching
var devCompiler = webpack(myDevConfig);

gulp.task("webpack-dev", function(callback) {
    // run webpack
    devCompiler.run(function(err, stats) {
        if(err) throw new gutil.PluginError("webpack-dev", err);
        gutil.log("[webpack-dev]", stats.toString({
            colors: true
        }));
        callback();
    });
});

// No need to reload all files maybe??
gulp.task("all-livereload", function() {
    gulp.src(baseClientPath + "/**/*")
    .pipe(livereload());
});
