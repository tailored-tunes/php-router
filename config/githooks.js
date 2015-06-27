'use strict';

module.exports = function() {
	return {
		'php-router': {
			'pre-push': 'default',
			'post-merge': {
				command: 'npm install'
			}
		}
	};
};
