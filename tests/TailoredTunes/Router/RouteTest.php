<?php
namespace TailoredTunes\Router;

class RouteTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RouteParameterMatchGenerator
	 */
	private $matcher;
	/**
	 * @var Route
	 */
	protected $route;

	/**
	 * @var string
	 */
	private $path = '/xxx';

	public function setUp() {
		$this->matcher = new RouteParameterMatchGenerator();
		$this->route = new Route($this->path, $this->matcher);
	}

	public function testParsing() {
		$config = [Route::HANDLER => 'A#b'];
		$this->route->addConfig($config);
		$route = $this->route->forVerb('GET');
		$this->assertTrue($route instanceof RoutePart, 'Not RouterPart given');
		$this->assertEquals('A', $route->controller(), 'Not the correct controller given');
		$this->assertEquals('b', $route->action(), 'Not the correct action given');
	}

	public function testRegex() {
		$expected = ['b' => 'geza'];
		$route = new Route('/a/:b/c', $this->matcher);
		$actual = $route->parameters('/a/geza/c');
		$this->assertEquals($expected['b'], $actual['b']);
	}

	public function testRegex2() {
		$expected = ['baby' => 'geza'];
		$route = new Route('/:baby', $this->matcher);
		$actual = $route->parameters('/geza');
		$this->assertEquals($expected['baby'], $actual['baby']);
	}

}

?>
