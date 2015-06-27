'use strict';

module.exports = function(grunt, option) {

	return {
		options: {
			phpmd: 'vendor/bin/phpmd',
			rulesets: [
				option.configDir + '/phpmd-ruleset.xml'
			]
		},
		files: option.phpSources
	};
};
