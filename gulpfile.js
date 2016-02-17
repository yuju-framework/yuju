var gulp = require('gulp');
var exec = require('child_process').exec;
var zip = require('gulp-zip');

// TODO: get num commit git show --pretty="format:" --name-only `git log --pretty="format:%H" --max-count={{NUMCOMMIT}}`

gulp.task('generate-zip',function() {
		exec('git show --pretty="format:" --name-only HEAD', function (err, stdout, stderr){
			var files = stdout.split("\n");
			gulp.src(files, {base: '.'})
				.pipe(zip('changes.zip'))
				.pipe(gulp.dest('.'));
		});
});
