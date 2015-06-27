<?php
namespace TailoredTunes\Router;

use PHPUnit_Framework_TestCase;
use TailoredTunes\RandomGenerator;

class RequestParamsTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var RandomGenerator
	 */
	private $random;

	/**
	 * @var array
	 */
	private $params;

	/**
	 * @var RequestParamBuilder
	 */
	private $builder;

	public function __construct() {
		$this->random = new RandomGenerator();
	}

	public function setUp() {
		$requestParams = $this->randomArray();
		$sessionParams = $this->randomArray();
		$serverParams = $this->randomArray();
		$cookieParams = $this->randomArray();
		$fileParams = $this->randomArray();
		$envParams = $this->randomArray();
		$this->params = [
			'request' => new ImmutableSuperglobal($requestParams),
			'session' => new MutableSuperglobal($sessionParams),
			'server'  => new ImmutableSuperglobal($serverParams),
			'cookies' => new MutableSuperglobal($cookieParams),
			'files'   => new ImmutableSuperglobal($fileParams),
			'env'     => new ImmutableSuperglobal($envParams),
		];

		$methods = array_keys($this->params);
		$this->builder = $this->getMockBuilder('\TailoredTunes\Router\RequestParamBuilder')
							  ->setMethods($methods)
							  ->disableArgumentCloning()
							  ->disableOriginalClone()
							  ->disableOriginalConstructor()
							  ->disableProxyingToOriginalMethods()
							  ->getMock();
	}

	public function testCreation() {
		foreach ($this->params as $key => $value) {
			$this->builder->expects($this->once())->method($key)->will($this->returnValue($value));
		}

		$requestParams = new RequestParams($this->builder);

		foreach ($this->params as $key => $value) {
			$this->assertEquals($value, $requestParams->$key(), $key . ' was not returned properly');
		}
	}

	public function testAddDynamicParams() {
		$requestParams = new RequestParams($this->builder);

		$key = $this->random->randomText();
		$value = $this->random->randomText();

		$requestParams->add($key, $value);

		$actual = $requestParams->get($key, '');
		$this->assertEquals($value, $actual);
	}

	public function testHasParam() {
		$requestParams = new RequestParams($this->builder);

		$key = $this->random->randomText();
		$value = $this->random->randomText();

		$requestParams->add($key, $value);

		$this->assertTrue($requestParams->has($key));
		$this->assertFalse($requestParams->has('notExistingKey'));
	}

	public function testGetParamFallback() {
		$requestParams = new RequestParams($this->builder);
		$fallback = $this->random->randomText();

		$actual = $requestParams->get('nonExistingKey', $fallback);

		$this->assertEquals($fallback, $actual);
	}

	public function testGetParamCallback() {
		$requestParams = new RequestParams($this->builder);
		$notExistingKey = $this->random->randomText();
		$fallbackValue = $this->random->randomText();

		$fallback = function ($key) use ($fallbackValue, $notExistingKey) {
			$this->assertEquals($notExistingKey, $key);

			return $fallbackValue;
		};

		$actual = $requestParams->get($notExistingKey, $fallback);

		$this->assertEquals($fallbackValue, $actual);
	}

	/**
	 * @return array
	 */
	private function randomArray() {
		return [$this->random->randomText()];
	}

}

?>
