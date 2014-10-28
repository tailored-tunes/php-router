<?php
namespace TailoredTunes\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    protected $object;

    public function testSimpleRoute()
    {
        $expected = new RoutePart("Index#home");
        $actual = $this->object->handle("/", "GET");
        $this->assertEquals(
            $expected->controller(),
            $actual->controller(),
            "Route controller was not resolved correctly"
        );
        $this->assertEquals(
            $expected->action(),
            $actual->action(),
            "Route action was not resolved correctly"
        );
    }

    public function testSimpleRoute2()
    {
        $expected = new RoutePart("Index#post");
        $actual = $this->object->handle("/", "POST");
        $this->assertEquals(
            $expected->controller(),
            $actual->controller(),
            "Route controller was not resolved correctly"
        );
        $this->assertEquals(
            $expected->action(),
            $actual->action(),
            "Route action was not resolved correctly"
        );
    }

    public function testParams()
    {
        $expected = new RoutePart("Index#handle");
        $param = "Lucy";
        $expected->addParameters(array("x" => $param));
        $actual = $this->object->handle(
            "/a/y?x=" . $param,
            "GET",
            array("x" => $param)
        );
        $this->assertEquals(
            $expected->controller(),
            $actual->controller(),
            "Route controller was not resolved correctly"
        );
        $this->assertEquals(
            $expected->action(),
            $actual->action(),
            "Route action was not resolved correctly"
        );
        $this->assertEquals(
            $expected->parameters(),
            $actual->parameters(),
            "Parameters not resolved"
        );

    }

    /**
     * @expectedException Exception
     */
    public function testNonemptyCreation()
    {
        $this->object->addRoutes();
    }

    /**
     * @dataProvider      lofasz()
     * @expectedException Exception
     */
    public function testFaultyCreation($param)
    {
        $this->object->addRoutes($param);
    }

    public function lofasz()
    {
        return array(array(""), array(1), array(null), array(true),
            array(false));
    }

    protected function setUp()
    {
        $this->object = new Router();
        $this->object->addRoutes($this->setUpRoutingTable());
    }

    private function setUpRoutingTable()
    {
        $table = array(array("/" => "Index#home"),
            array("/" => "Index#post", "via" => "POST"),
            array("/a/y" => "Index#handle"));
        return $table;
    }
}
