<?php
namespace TailoredTunes\Router;

class Route
{

    const HANDLER = "handler";
    const VIA = "via";

    /**
     * @var RoutePart[]
     */
    private $routeParts = array();

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;

    }

    public function addConfig($routeConfig)
    {
        if (is_array($routeConfig)) {
            if (!array_key_exists(self::VIA, $routeConfig)) {
                $routeConfig[self::VIA] = "GET";
            }
            $this->routeParts[$routeConfig[self::VIA]] =
                new RoutePart($routeConfig[self::HANDLER]);
        }
    }

    /**
     * @param String $string http verb
     *
     * @return RoutePart
     */
    public function forVerb($string)
    {
        if (array_key_exists($string, $this->routeParts)) {
            return $this->routeParts[$string];
        }

        return null;

    }

    public function parameters($uri)
    {
        $internalUri = $this->uri;
        $pattern = "/^" . addcslashes(preg_replace("/:([^\/]+)/", "(?P<$1>[^/]+)", $internalUri), "/") . "$/";
        preg_match($pattern, $uri, $matches);
        $matches = $this->removeTheBaseUrl($matches);
        return $matches;
    }

    private function removeTheBaseUrl($matches)
    {
        array_shift($matches);
        return $matches;
    }
}
