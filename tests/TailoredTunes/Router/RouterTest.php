<?php
namespace TailoredTunes\Router;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */

class RouterTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RouteParameterMatchGenerator
	 */
	private $matcher;
	/**
	 * @var Router
	 */
	protected $object;

	public function setUp() {
		$this->matcher = new RouteParameterMatchGenerator();
		$this->object = new Router($this->matcher);
		$this->object->addRoutes($this->setUpRoutingTable());

	}

	public function testSimpleRoute() {
		$expected = new RoutePart('Index#home');
		$actual = $this->object->handle('/', 'GET');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testSimpleRoute2() {
		$expected = new RoutePart('Index#post');
		$actual = $this->object->handle('/', 'POST');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testSimpleRoute3() {
		$expected = new RoutePart('Index#postit');
		$actual = $this->object->handle('/post', 'POST');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testSimpleRoute31() {
		$expected = new RoutePart('Index#handle2');
		$actual = $this->object->handle('/lala', 'GET');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testSimpleRoute4() {
		$expected = new RoutePart('Index#handle3');
		$actual = $this->object->handle('/lala/1', 'GET');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testTrailingSlash() {
		$expected = new RoutePart('Index#handle3');
		$actual = $this->object->handle('/lala/1/', 'GET');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	public function testQueryString() {
		$expected = new RoutePart('Index#handle4');
		$actual = $this->object->handle('/something?a=b', 'GET');
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
	}

	/**
	 * @expectedException \TailoredTunes\Router\PathNotFoundException
	 */
	public function testPathNotFounds() {
		$this->object->handle('/gib/be/rish', 'GET');
	}

	/**
	 * @expectedException \TailoredTunes\Router\PathNotFoundException
	 */
	public function testBadVerb() {
		$this->object->handle('/something', 'POST');
	}

	public function testParams() {
		$expected = new RoutePart('Index#handle');
		$param = 'Lucy';
		$expected->addParameters(['x' => $param]);
		$actual = $this->object->handle(
			'/a/y?x=' . $param,
			'GET',
			['x' => $param]
		);
		$this->assertEquals(
			$expected->controller(),
			$actual->controller(),
			'Route controller was not resolved correctly'
		);
		$this->assertEquals(
			$expected->action(),
			$actual->action(),
			'Route action was not resolved correctly'
		);
		$this->assertEquals(
			$expected->parameters(),
			$actual->parameters(),
			'Parameters not resolved'
		);
	}

	public function provider() {
		return [
			[''],
			[1],
			[null],
			[true],
			[false]
		];
	}

	private function setUpRoutingTable() {
		$table = [
			['/' => 'Index#home'],
			[
				'/'   => 'Index#post',
				'via' => 'POST'
			],
			[
				'/post' => 'Index#postit',
				'via'   => 'POST'
			],
			['/a/y' => 'Index#handle'],
			['/:a' => 'Index#handle2'],
			['/:a/:b' => 'Index#handle3'],
			['/something' => 'Index#handle4']
		];

		return $table;
	}

}

?>
