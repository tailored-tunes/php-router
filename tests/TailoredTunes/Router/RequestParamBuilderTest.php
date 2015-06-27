<?php
namespace TailoredTunes\Router;

use TailoredTunes\RandomGenerator;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RequestParamBuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RandomGenerator
	 */
	private $random;

	/**
	 * @var RequestParamBuilder
	 */
	private $builder;

	/**
	 * @var array
	 */
	private $data;

	public function __construct() {
		$this->random = new RandomGenerator();
	}

	public function setUp() {
		$this->builder = new RequestParamBuilder();
		$this->data = $this->randomArray();
	}

	public function testEmptyRequest() {
		$actual = $this->builder->request();
		$this->assertTrue($actual instanceof ImmutableSuperglobal);
	}

	public function testRequest() {
		$this->builder->withRequest($this->data);
		$expected = new ImmutableSuperglobal($this->data);
		$actual = $this->builder->request();
		$this->assertEquals($expected, $actual);
	}

	public function testEmptySession() {
		$actual = $this->builder->session();
		$this->assertTrue($actual instanceof MutableSuperglobal);
	}

	public function testSession() {
		$this->builder->withSession($this->data);
		$expected = new MutableSuperglobal($this->data);
		$actual = $this->builder->session();
		$this->assertEquals($expected, $actual);
	}

	public function testEmptyServer() {
		$actual = $this->builder->server();
		$this->assertTrue($actual instanceof ImmutableSuperglobal);
	}

	public function testServer() {
		$this->builder->withServer($this->data);
		$expected = new ImmutableSuperglobal($this->data);
		$actual = $this->builder->server();
		$this->assertEquals($expected, $actual);
	}

	public function testEmptyCookies() {
		$actual = $this->builder->cookies();
		$this->assertTrue($actual instanceof MutableSuperglobal);
	}

	public function testCookies() {
		$this->builder->withCookies($this->data);
		$expected = new MutableSuperglobal($this->data);
		$actual = $this->builder->cookies();
		$this->assertEquals($expected, $actual);
	}

	public function testEmptyFiles() {
		$actual = $this->builder->files();
		$this->assertTrue($actual instanceof ImmutableSuperglobal);
	}

	public function testFiles() {
		$this->builder->withFiles($this->data);
		$expected = new ImmutableSuperglobal($this->data);
		$actual = $this->builder->files();
		$this->assertEquals($expected, $actual);
	}

	public function testEmptyEnv() {
		$actual = $this->builder->env();
		$this->assertTrue($actual instanceof ImmutableSuperglobal);
	}

	public function testEnv() {
		$this->builder->withEnv($this->data);
		$expected = new ImmutableSuperglobal($this->data);
		$actual = $this->builder->env();
		$this->assertEquals($expected, $actual);
	}

	public function testChaining() {
		$request = $this->randomArray();
		$session = $this->randomArray();
		$server = $this->randomArray();
		$cookies = $this->randomArray();
		$files = $this->randomArray();
		$env = $this->randomArray();

		$this->builder->withRequest($request)
					  ->withSession($session)
					  ->withServer($server)
					  ->withCookies($cookies)
					  ->withFiles($files)
					  ->withEnv($env);

		$this->assertEquals($request, $this->builder->request()->getAll());
		$this->assertEquals($session, $this->builder->session()->getAll());
		$this->assertEquals($server, $this->builder->server()->getAll());
		$this->assertEquals($cookies, $this->builder->cookies()->getAll());
		$this->assertEquals($files, $this->builder->files()->getAll());
		$this->assertEquals($env, $this->builder->env()->getAll());
	}

	/**
	 * @return array
	 */
	private function randomArray() {
		$numberOfEntries = $this->random->randomNumber(10);
		$data = [];

		for ($i = 0; $i < $numberOfEntries; $i++) {
			array_push($data, $this->random->randomText());
		}

		return $data;
	}

}

?>
