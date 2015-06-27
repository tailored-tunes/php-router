'use strict';

module.exports = function(grunt) {

	var options = {
		phpSources: [
			'**/*.php',
			'!vendor/**/*',
			'!node_modules/**/*'
		],
		testFiles: 'tests/',
		configDir: 'config',
		reportsDir: 'reports'
	}, config = require('load-grunt-configs')(grunt, options);
	require('load-grunt-tasks')(grunt);

	grunt.initConfig(config);

	grunt.registerTask('default', [
		'phpunit-runner',
		'phpcs',
		'phpmd-runner'
	]);
};
