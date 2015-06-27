<?php
namespace TailoredTunes\Router;

class RoutePart {

	/**
	 * @var string
	 */
	private $controller;

	/**
	 * @var string
	 */
	private $action;

	/**
	 * @var array
	 */
	private $paramteres = [];

	/**
	 * @param string $routeString
	 */
	public function __construct($routeString) {
		$parts = explode('#', $routeString);
		$this->controller = $parts[0];
		$this->action = $parts[1];
	}

	/**
	 * @return string
	 */
	public function controller() {
		return $this->controller;
	}

	/**
	 * @return string
	 */
	public function action() {
		return $this->action;
	}

	/**
	 * @param array $params
	 *
	 * @return void
	 */
	public function addParameters(array $params) {
		$this->paramteres = array_merge($this->paramteres, $params);
	}

	/**
	 * @return array
	 */
	public function parameters() {
		return $this->paramteres;
	}

}

?>
