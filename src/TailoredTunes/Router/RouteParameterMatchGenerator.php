<?php
namespace TailoredTunes\Router;

class RouteParameterMatchGenerator
{

    public function getRegexPattern($path)
    {
        $pattern = "/^" . addcslashes(preg_replace("/:([^\/]+)/", "(?P<$1>[^/]+)", $path), "/") . "$/";
        return $pattern;
    }
}
