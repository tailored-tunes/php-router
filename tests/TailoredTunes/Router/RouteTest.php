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

    public function testStuff()
    {
        $config = array(Route::HANDLER => "A#b");
        $this->route->addConfig($config);
        $r = $this->route->forVerb("GET");
        $this->assertTrue($r instanceof RoutePart, "Not RouterPart given");
        $this->assertEquals("A", $r->controller(), "Not the correct controller given");
        $this->assertEquals("b", $r->action(), "Not the correct action given");

    }

    public function testRegex()
    {
        $expected = array("b" => "geza");
        $a = new Route("/a/:b/c");
        $actual = $a->parameters("/a/geza/c");
        $this->assertEquals($expected["b"], $actual["b"]);
    }

    public function testRegex2()
    {
        $expected = array("b" => "geza");
        $a = new Route("/:b");
        $actual = $a->parameters("/geza");
        $this->assertEquals($expected["b"], $actual["b"]);
    }
}
