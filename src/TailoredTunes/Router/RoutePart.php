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
	 * @var RequestParams
	 */
	private $paramteres;

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
	 * @param RequestParams $params
	 *
	 * @return void
	 */
	public function setParameters(RequestParams $params) {
		if ($this->paramteres === null) {
			$this->paramteres = $params;
		}
	}

	/**
	 * @return RequestParams
	 */
	public function parameters() {
		return $this->paramteres;
	}

}

?>
