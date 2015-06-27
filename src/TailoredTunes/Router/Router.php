<?php
namespace TailoredTunes\Router;

class Router {

	/**
	 * @var Route[]
	 */
	private $routingTable = [];
	/**
	 * @var RouteParameterMatchGenerator
	 */
	private $magic;

	/**
	 * @param \TailoredTunes\Router\RouteParameterMatchGenerator $magic
	 */
	public function __construct(RouteParameterMatchGenerator $magic) {
		$this->magic = $magic;
	}

	/**
	 * @param array $routingTable
	 *
	 * @return void
	 */
	public function addRoutes(array $routingTable) {
		$this->routingTable = $routingTable;
		foreach ($routingTable as $route) {
			$keys = array_keys($route);
			$urlParts = explode('?', $keys[0]);
			$uri = $urlParts[0];
			if (array_key_exists($uri, $this->routingTable)) {
				$x = $this->routingTable[$uri];
			} else {
				$x = new Route($uri, $this->magic);
			}

			$z = [Route::HANDLER => $route[$keys[0]]];
			unset($route[$uri]);
			$routeConfig = array_merge($z, $route);
			$x->addConfig($routeConfig);
			$this->routingTable[$uri] = $x;
		}
	}

	/**
	 * @param string        $originalUri
	 * @param string        $httpMethod
	 *
	 * @param RequestParams $params
	 *
	 * @return RoutePart
	 *
	 * @throws PathNotFoundException When it was not possible to find a matching route.
	 */
	public function handle($originalUri, $httpMethod, RequestParams $params = null) {
		if ($params === null) {
			$params = new RequestParams(new RequestParamBuilder());
		}

		$uri = $this->stripTrailingSlash($originalUri);

		$uri = $this->removeQueryParametersFromTheUri($uri);

		$url = parse_url($uri);
		$effectiveUri = $url['path'];

		$route = $this->getRouteForUriAndMethod($httpMethod, $effectiveUri);

		$handler = $this->getHandlerForUri($httpMethod, $route, $effectiveUri);

		$uriParams = $route->parameters($uri);

		foreach ($uriParams as $name => $value) {
			$params->add($name, $value);
		}

		$originalUrl = parse_url($originalUri);
		if (array_key_exists('query', $originalUrl)) {
			parse_str($originalUrl['query'], $queryParams);

			foreach ($queryParams as $name => $value) {
				$params->add($name, $value);
			}
		}

		$handler->setParameters($params);

		return $handler;
	}

	/**
	 * @param string $uri
	 *
	 * @return string
	 */
	private function stripTrailingSlash($uri) {
		if (strlen($uri) > 1 && substr($uri, -1) == '/') {
			$uri = substr($uri, 0, -1);

			return $uri;
		}

		return $uri;
	}

	/**
	 * @param string $uri
	 *
	 * @return string
	 */
	private function removeQueryParametersFromTheUri($uri) {
		$qstrPos = strpos($uri, '?');
		if (!($qstrPos === false)) {
			$uri = substr($uri, 0, $qstrPos);

			return $uri;
		}

		return $uri;
	}

	/**
	 * @param string $httpMethod
	 * @param string $effectiveUri
	 *
	 * @return boolean
	 */
	private function needRegex($httpMethod, $effectiveUri) {
		$needRegex = true;
		if (array_key_exists($effectiveUri, $this->routingTable)) {
			if ($this->routingTable[$effectiveUri]->forVerb($httpMethod) !== null) {
				$needRegex = false;

				return $needRegex;
			}

			return $needRegex;
		}

		return $needRegex;
	}

	/**
	 * @param string $httpMethod
	 * @param Route  $route
	 * @param string $effectiveUri
	 *
	 * @return RoutePart
	 * @throws PathNotFoundException When it was not possible to find a matching route.
	 */
	private function getHandlerForUri($httpMethod, Route $route, $effectiveUri) {
		$handler = $route->forVerb($httpMethod);
		if ($handler == null) {
			throw new PathNotFoundException($httpMethod . ' - ' . $effectiveUri);
		}

		return $handler;
	}

	/**
	 * @param string $effectiveUri
	 *
	 * @return Route
	 * @throws PathNotFoundException When it was not possible to find a matching route.
	 */
	private function fallbackToDefault($effectiveUri) {
		if (!array_key_exists($effectiveUri, $this->routingTable)) {
			throw new PathNotFoundException($effectiveUri);
		}

		$route = $this->routingTable[$effectiveUri];

		return $route;
	}

	/**
	 * @param string $effectiveUri
	 *
	 * @return Route
	 * @throws PathNotFoundException When it was not possible to find a matching route.
	 */
	private function getResolvedRoute($effectiveUri) {
		foreach (array_keys($this->routingTable) as $path) {
			$pattern = $this->magic->getRegexPattern($path);

			if (preg_match($pattern, $effectiveUri, $matches) === 1) {
				array_pop($matches);
				if (count($matches) > 0) {
					return $this->routingTable[$path];
				}
			}
		}

		throw new PathNotFoundException($effectiveUri);
	}

	/**
	 * @param string $httpMethod
	 * @param string $effectiveUri
	 *
	 * @return Route
	 * @throws PathNotFoundException When it was not possible to find a matching route.
	 */
	private function getRouteForUriAndMethod($httpMethod, $effectiveUri) {
		$needRegex = $this->needRegex($httpMethod, $effectiveUri);
		try {
			if ($needRegex) {
				return $this->getResolvedRoute($effectiveUri);
			}

			return $this->fallbackToDefault($effectiveUri);
		} catch (PathNotFoundException $exception) {
			return $this->fallbackToDefault($effectiveUri);
		}
	}

}

?>
