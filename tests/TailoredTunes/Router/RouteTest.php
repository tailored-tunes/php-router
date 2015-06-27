<?php
namespace TailoredTunes\Router;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Route
     */
    protected $route;

    private $path = "/xxx";

    public function setUp()
    {
        $this->route = new Route($this->path);
    }

    public function testParsing()
    {
        $config = array(Route::HANDLER => "A#b");
        $this->route->addConfig($config);
        $route = $this->route->forVerb("GET");
        $this->assertTrue($route instanceof RoutePart, "Not RouterPart given");
        $this->assertEquals("A", $route->controller(), "Not the correct controller given");
        $this->assertEquals("b", $route->action(), "Not the correct action given");

    }

    public function testRegex()
    {
        $expected = array("b" => "geza");
        $route = new Route("/a/:b/c");
        $actual = $route->parameters("/a/geza/c");
        $this->assertEquals($expected["b"], $actual["b"]);
    }

    public function testRegex2()
    {
        $expected = array("baby" => "geza");
        $route = new Route("/:baby");
        $actual = $route->parameters("/geza");
        $this->assertEquals($expected["baby"], $actual["baby"]);
    }
}
