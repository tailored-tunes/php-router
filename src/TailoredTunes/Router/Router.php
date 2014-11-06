<?php
namespace TailoredTunes\Router;

class Router
{

    /**
     * @var Route[]
     */
    private $routingTable = array();

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
            $z = array(Route::HANDLER => $route[$keys[0]]);
            unset($route[$uri]);
            $routeConfig = array_merge($z, $route);
            $x->addConfig($routeConfig);
            $this->routingTable[$uri] = $x;
        }
    }

    /**
     * @param $uri
     * @param $httpMethod
     *
     * @return null|RoutePart
     */
    public function handle($uri, $httpMethod, $params = array())
    {
        $url = parse_url($uri);
        $effectiveUri = $url["path"];
        if (!array_key_exists($effectiveUri, $this->routingTable)) {
            foreach (array_keys($this->routingTable) as $path) {
                $pattern = "/^" . addcslashes(preg_replace("/:([^\/])+/", "(?P<$1>[^/]+)", $path), "/") . "$/";
                if (preg_match($pattern, $uri, $m) === 1) {
                    array_pop($m);
                    if (count($m) > 0) {
//                        var_dump($uri, $path, $pattern, $m);
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
