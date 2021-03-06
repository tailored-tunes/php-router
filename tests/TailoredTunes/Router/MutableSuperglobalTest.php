<?php

namespace TailoredTunes\Router;

use TailoredTunes\RandomGenerator;

class MutableSuperglobalTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RandomGenerator
	 */
	private $random;

	public function __construct() {
		$this->random = new RandomGenerator();
	}

	public function testSet() {
		$mySession = [];
		$sess = new MutableSuperglobal($mySession);
		$key = $this->random->randomText();
		$value = $this->random->randomText();
		$sess->set($key, $value);

		$this->assertEquals($mySession[$key], $value);
	}

	public function testUnset() {
		$mySession = [];
		$sess = new MutableSuperglobal($mySession);
		$key = $this->random->randomText();
		$value = $this->random->randomText();
		$sess->set($key, $value);
		$sess->delete($key);
		$this->assertFalse(array_key_exists($key, $mySession));
	}

	public function testGet() {
		$key = $this->random->randomText();
		$value = $this->random->randomText();
		$mySession = [
			$key => $value
		];

		$sess = new MutableSuperglobal($mySession);
		$this->assertEquals($sess->get($key, ''), $value, 'Did not return the value from the session store');
	}

	public function testGetDefaultFallback() {
		$notExistingKey = $this->random->randomText();
		$defaultValue = $this->random->randomText();
		$mySession = [];

		$sess = new MutableSuperglobal($mySession);
		$this->assertEquals(
			$sess->get($notExistingKey, $defaultValue),
			$defaultValue,
			'Did not return the default value'
		);
	}

	public function testGetDefaultFallbackClosure() {
		$notExistingKey = $this->random->randomText();
		$valueFromClosure = $this->random->randomText();

		$defaultValue = function () use ($valueFromClosure) {
			return $valueFromClosure;
		};

		$mySession = [];

		$sess = new MutableSuperglobal($mySession);
		$actual = $sess->get($notExistingKey, $defaultValue);
		$this->assertEquals($valueFromClosure, $actual, 'Did not run closure as default value');
	}

	public function testHas() {
		$key = $this->random->randomText();
		$value = $this->random->randomText();

		$mySession = [];
		$sess = new MutableSuperglobal($mySession);

		$this->assertFalse($sess->has($key));

		$mySession[$key] = $value;

		$this->assertTrue($sess->has($key));
	}

	public function testGetAllCannotModify() {
		$key = $this->random->randomText();
		$value = $this->random->randomText();
		$mySession = [
			$key => $value
		];

		$sess = new MutableSuperglobal($mySession);

		$all = $sess->getAll();
		$this->assertEquals($value, $all[$key]);

		$all[$key] = 'somethingElse';

		$this->assertEquals('somethingElse', $all[$key]);
		$this->assertEquals($value, $sess->get($key, ''));

	}

}

?>
