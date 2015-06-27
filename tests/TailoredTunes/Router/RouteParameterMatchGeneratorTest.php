<?php
namespace TailoredTunes\Router;

class RouteParameterMatchGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testMagic() {
		$magic = new RouteParameterMatchGenerator();
		$path = '/something/:id/:name';

		$actual = $magic->getRegexPattern($path);

		$expected = '/^\/something\/(?P<id>[^\/]+)\/(?P<name>[^\/]+)$/';
		$this->assertEquals($expected, $actual);
	}

}

?>
