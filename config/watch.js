'use strict';

module.exports = function (grunt, options) {

	grunt.event.on('watch', function (action, filepath) {
		if (grunt.file.isMatch(grunt.config('watch.php.files'), filepath)) {
			grunt.config('phpcs.application.src', [filepath]);
			grunt.config('phpmd-runner.files', [filepath]);
		}
	});

	return {
		php: {
			files: options.phpSources,
			tasks: [
				'phpunit-runner:fast',
				'phpcs',
				'phpmd-runner'
			],
			options: {
				spawn: false
			}
		},
		phpmdConfig: {
			files: [
				options.configDir + '/phpmd-ruleset.xml',
				options.configDir + '/phpmd-runner.js'
			],
			tasks: [
				'phpmd-runner'
			]
		}

	};
};
