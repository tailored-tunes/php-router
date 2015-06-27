<?php
namespace TailoredTunes\Router;

class RouteParameterMatchGenerator {

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function getRegexPattern($path) {
		$pattern = '/^' . addcslashes(preg_replace('/:([^\/]+)/', '(?P<$1>[^/]+)', $path), '/') . '$/';

		return $pattern;
	}

}

?>
