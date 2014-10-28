<?php
namespace TailoredTunes\Router;

class RoutePartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RoutePart
     */
    protected $routePart;

    public function testBasic()
    {
        $rp = new RoutePart("A#b");
        $this->assertEquals(
            "A",
            $rp->controller(),
            "Controller was not parsed properly"
        );
        $this->assertEquals(
            "b",
            $rp->action(),
            "Action was not parsed properly"
        );

    }
}
