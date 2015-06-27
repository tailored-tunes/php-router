<?php
namespace TailoredTunes\Router;

use PHPUnit_Framework_TestCase;
use TailoredTunes\RandomGenerator;

class RequestParamsTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var RandomGenerator
	 */
	private $random;

	public function __construct() {
		$this->random = new RandomGenerator();
	}

	public function testCreation() {
		$params = [
			'request' => new ImmutableSuperglobal($this->randomArray()),
			'session' => new MutableSuperglobal($this->randomArray()),
			'server'  => new ImmutableSuperglobal($this->randomArray()),
			'cookies' => new MutableSuperglobal($this->randomArray()),
			'files'   => new ImmutableSuperglobal($this->randomArray()),
		];

		$builder = $this->getMockBuilder('\TailoredTunes\Router\RequestParamBuilder')
						->setMethods(array_keys($params))
						->disableArgumentCloning()
						->disableOriginalClone()
						->disableOriginalConstructor()
						->disableProxyingToOriginalMethods()
						->getMock();

		foreach ($params as $key => $value) {
			$builder->expects($this->once())->method($key)->will($this->returnValue($value));
		}

		$stuff = new RequestParams($builder);

		foreach ($params as $key => $value) {
			$this->assertEquals($value, $stuff->$key(), $key . ' was not returned properly');
		}
	}

	/**
	 * @return array
	 */
	private function randomArray() {
		return [$this->random->randomText()];
	}

}

?>
