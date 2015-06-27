'use strict';

module.exports = function (grunt, options) {
	return {
		application: {
			src: options.phpSources
		},
		options: {
			bin: 'vendor/bin/phpcs',
			standard: options.configDir + '/checkstyle-ruleset.xml',
			report: 'full'
		}
	};
};
