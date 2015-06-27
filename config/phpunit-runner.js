'use strict';

module.exports = function(grunt, config) {
	return {
		fast: {
			options: {
				phpunit: 'vendor/bin/phpunit',
				bootstrap: 'tests/bootstrap.php',
				failOnFailures: true
			},
			files: [
				{
					src: config.testFiles
				}
			]
		}

	};
};
