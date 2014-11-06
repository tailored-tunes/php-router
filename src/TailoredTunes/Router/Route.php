<?php
namespace TailoredTunes\Router;

class Route
{

    const HANDLER = "handler";
    const VIA = "via";

    /**
     * @var RoutePart[]
     */
    private $s = array();

    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;

    }

    public function addConfig($routeConfig)
    {
        if (is_array($routeConfig)) {
            if (!array_key_exists(self::VIA, $routeConfig)) {
                $routeConfig[self::VIA] = "DEFAULT";
            }
            $this->s[$routeConfig[self::VIA]] =
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
        if (array_key_exists($string, $this->s)) {
            return $this->s[$string];
        }
        if ($string == "DEFAULT") {
            return null;
        }
        return $this->forVerb("DEFAULT");

    }

    public function parameters($uri)
    {
        $a = $this->uri;
        $pattern = "/^" . addcslashes(preg_replace("/:([^\/]+)/", "(?P<$1>[^/]+)", $a), "/") . "$/";
        preg_match($pattern, $uri, $m);
        $m = $this->removeTheBaseUrl($m);
        return $m;
    }

    private function removeTheBaseUrl($m)
    {
        array_shift($m);
        return $m;
    }
}
