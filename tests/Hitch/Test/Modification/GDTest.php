<?php
namespace Hitch\Test\Modification;

use Hitch\Test\TestCase;
use Mockery as m;
use Hitch\Modification\GD;

class GDTest extends TestCase
{
    public function setup()
    {
        parent::setup();

        $this->image = m::mock("Hitch\Image")
            ->shouldDeferMissing();
        $this->image->setOriginalPath(__DIR__ . "/fixtures/image.png");
    }

    public function testResizeSetsNewDimensions()
    {
        $width = 100;
        $height = 200;
        $gd = new GD;

        $gd->resize($this->image, $width, $height);

        $this->assertEquals(100, $this->image->getWidth());
        $this->assertEquals(200, $this->image->getHeight());
    }

    public function testResizeResizesResource()
    {
        $gd = new GD;
        $gd->resize($this->image, 100, 200);
        $resource = $this->image->getData();
        $this->assertEquals(100, imagesx($resource));
        $this->assertEquals(200, imagesy($resource));
    }
}
