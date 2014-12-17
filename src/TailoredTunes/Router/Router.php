<?php
namespace TailoredTunes\Router;

class Router
{

    /**
     * @var Route[]
     */
    private $routingTable = [];

    public function addRoutes(Array $routingTable)
    {
        $this->routingTable = $routingTable;
        foreach ($routingTable as $route) {
            $keys = array_keys($route);
            $urlParts = explode("?", $keys[0]);
            $uri = $urlParts[0];
            if (array_key_exists($uri, $this->routingTable)) {
                $x = $this->routingTable[$uri];
            } else {
                $x = new Route($uri);
            }
            $z = [Route::HANDLER => $route[$keys[0]]];
            unset($route[$uri]);
            $routeConfig = array_merge($z, $route);
            $x->addConfig($routeConfig);
            $this->routingTable[$uri] = $x;
        }
    }

    /**
     * @param       $uri
     * @param       $httpMethod
     *
     * @param array $params
     * @return null|RoutePart
     * @throws PathNotFoundException
     */
    public function handle($uri, $httpMethod, $params = [])
    {
        if (strlen($uri) > 1 && substr($uri, -1) == '/') {
            $uri = substr($uri, 0, -1);
        }

        $qstrPos = strpos($uri, '?');
        if (!($qstrPos === false)) {
            $uri = substr($uri, 0, $qstrPos);
        }

        $url = parse_url($uri);
        $effectiveUri = $url["path"];

        $needRegex = false;

        if (array_key_exists($effectiveUri, $this->routingTable)) {
            $route = $this->routingTable[$effectiveUri];
            if ($route->forVerb($httpMethod) === null) {
                $needRegex = true;
            }
        } else {
            $needRegex = true;
        }

        if ($needRegex) {
            foreach (array_keys($this->routingTable) as $path) {
                if ($path === $effectiveUri) {
                    continue;
                }
                $pattern = "/^" . addcslashes(preg_replace("/:([^\/]+)/", "(?P<$1>[^/]+)", $path), "/") . "$/";
                if (preg_match($pattern, $effectiveUri, $m) === 1) {
                    array_pop($m);
                    if (count($m) > 0) {
                        $route = $this->routingTable[$path];
                    }
                }
            }
            if (!isset($route)) {
                throw new PathNotFoundException($effectiveUri);
            }
        }
        if (!isset($route)) {
            $route = $this->routingTable[$effectiveUri];
        }
        $handler = $route->forVerb($httpMethod);
        if (null == $handler) {
            throw new PathNotFoundException($httpMethod . ' - ' . $effectiveUri);
        }
        $handler->addParameters($route->parameters($uri));
        $handler->addParameters($params);
        return $handler;
    }
}
