<?php
namespace TailoredTunes\Router;

class RoutePartTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var RoutePart
	 */
	protected $routePart;

	public function testBasic() {
		$routePart = new RoutePart('A#b');
		$this->assertEquals(
			'A',
			$routePart->controller(),
			'Controller was not parsed properly'
		);
		$this->assertEquals(
			'b',
			$routePart->action(),
			'Action was not parsed properly'
		);
	}

}

?>
