<?php
namespace TailoredTunes\Router;

class RoutePart
{

    /**
     * @var String
     */
    private $controller;

    /**
     * @var String
     */
    private $action;

    /**
     * @var array
     */
    private $paramteres = array();

    /**
     * @param $routeString
     */
    public function __construct($routeString)
    {
        $parts = explode("#", $routeString);
        $this->controller = $parts[0];
        $this->action = $parts[1];

    }

    public function controller()
    {
        return $this->controller;
    }

    public function action()
    {
        return $this->action;
    }

    public function addParameters(Array $params)
    {
        $this->paramteres = array_merge($this->paramteres, $params);
    }

    public function parameters()
    {
        return $this->paramteres;
    }
}
