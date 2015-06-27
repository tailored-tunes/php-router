<?php
namespace TailoredTunes\Router;

class Route {

	/**
	 *
	 */
	const HANDLER = 'handler';
	/**
	 *
	 */
	const VIA = 'via';

	/**
	 * @var RoutePart[]
	 */
	private $routeParts = [];

	/**
	 * @var string
	 */
	private $uri;
	/**
	 * @var \TailoredTunes\Router\RouteParameterMatchGenerator
	 */
	private $matcher;

	/**
	 * @param string                                             $uri
	 * @param \TailoredTunes\Router\RouteParameterMatchGenerator $matcher
	 */
	public function __construct($uri, RouteParameterMatchGenerator $matcher) {
		$this->uri = $uri;

		$this->matcher = $matcher;
	}

	/**
	 * @param array $routeConfig
	 *
	 * @return void
	 */
	public function addConfig(array $routeConfig) {
		if (is_array($routeConfig)) {
			if (!array_key_exists(self::VIA, $routeConfig)) {
				$routeConfig[self::VIA] = 'GET';
			}

			$this->routeParts[$routeConfig[self::VIA]]
				= new RoutePart($routeConfig[self::HANDLER]);
		}
	}

	/**
	 * @param string $verb
	 *
	 * @return RoutePart
	 */
	public function forVerb($verb) {
		if (array_key_exists($verb, $this->routeParts)) {
			return $this->routeParts[$verb];
		}

		return null;
	}

	/**
	 * @param string $uri
	 *
	 * @return array
	 */
	public function parameters($uri) {
		$internalUri = $this->uri;
		$pattern = $this->matcher->getRegexPattern($internalUri);
		preg_match($pattern, $uri, $matches);
		$matches = $this->removeTheBaseUrl($matches);

		return $matches;
	}

	/**
	 * @param array $matches
	 *
	 * @return mixed
	 */
	private function removeTheBaseUrl(array $matches) {
		array_shift($matches);

		return $matches;
	}

}

?>
