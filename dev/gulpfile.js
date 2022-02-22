const gulp = require("gulp");
const autoprefixer = require("gulp-autoprefixer");
const del = require("del");
const sass = require("gulp-sass")(require("sass"));

const browserSync = require("browser-sync");
const phpConnect = require('gulp-connect-php');

//Php connect
function connectSync() {
    phpConnect.server({
        port: 8000,
        keepalive: true,
        base: "./public",
    }, function () {
        browserSync({
            proxy: '127.0.0.1:8000',
            notify: false
        });
    });
}

// BrowserSync Reload
function browserSyncReload(done) {
    browserSync.reload();
    done();
}


// Watch files
function watchPhp() {
    gulp.watch("./**/*.php", gulp.series(browserSyncReload));
}

function watchJS() {
    cleanScripts();
    buildScripts();
    gulp.watch("./resources/js/**/*.js", gulp.series(buildScripts, browserSyncReload))
}

function cleanScripts() {
    return del(["./public/js/**/*.js"])
}

function buildScripts() {
    return gulp.src("./resources/js/**/*.js").pipe(gulp.dest("./public/js"))
}

function buildStyles() {
    return gulp
        .src("./resources/sass/**/*.scss")
        .pipe(sass().on("error", sass.logError))
        .pipe(
            autoprefixer({
                cascade: false,
            })
        )
        .pipe(gulp.dest("./public/css"));
}


function cleanStyles() {
    return del(["./public/css/**/*.css"])
}

function watchSass() {
    cleanStyles();
    buildStyles();
    gulp.watch("./resources/sass/**/*.scss", gulp.series(buildStyles, browserSyncReload))
}


exports.watch = gulp.parallel([watchPhp, watchSass, watchJS, connectSync])