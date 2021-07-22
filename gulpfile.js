const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const terser = require('gulp-terser');
const browserSync = require('browser-sync').create();


function scssTask() {
	return src('./src/scss/main.scss')
		.pipe(sass())
		.pipe(postcss([cssnano()]))
		.pipe(dest('./assets'));
}

function jsTask() {
	return src('./src/js/main.js')
		.pipe(terser())
		.pipe(dest('./assets'));
}

function browserSyncServe(cb) {
	browserSync.init({
		server: {
			baseDir: '.'
		}
	});
	cb();
}

function browserSyncReload(cb) {
	browserSync.reload();
	cb();
}

function watchTask() {
	watch('*.php', browserSyncReload);
	watch(['./src/js/**/*.js','./src/scss/**/*.js'], series(scssTask, jsTask, browserSyncReload));
}

exports.style = scssTask;
exports.script = jsTask;

exports.compile = series(scssTask, jsTask)

exports.default = series(
	scssTask,
	jsTask,
	browserSyncServe,
	watchTask
)

