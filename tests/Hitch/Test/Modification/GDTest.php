<?php
namespace Hitch\Test\Modification;
// @codingStandardsIgnoreFile

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
        $modifier = new GD;

        $modifier->resize($this->image, $width, $height);

        $this->assertEquals(100, $this->image->getWidth());
        $this->assertEquals(200, $this->image->getHeight());
    }

    public function testResizeResizesResource()
    {
        $modifier = new GD;
        $modifier->resize($this->image, 100, 200);
        $resource = $this->image->getData();
        $this->assertEquals(100, imagesx($resource));
        $this->assertEquals(200, imagesy($resource));
    }

    public function testResizeKeepAspectRatioRetainsAspectRatio()
    {
        $this->image->setWidth(100);
        $this->image->setHeight(200);
        $aspect = $this->image->getWidth() / $this->image->getHeight();

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(
            $aspect,
            $this->image->getWidth() / $this->image->getHeight()
        );
    }

    public function testResizeKeepAspectResizesVertically()
    {
        $this->image->setWidth(100);
        $this->image->setHeight(200);

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(100, $this->image->getHeight());
    }

    public function testResizeKeepAspectResizesHorizontally()
    {
        $this->image->setWidth(200);
        $this->image->setHeight(100);

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(100, $this->image->getWidth());
    }

    public function testResizeKeepAspectResizesOtherDimension()
    {
        $this->image->setWidth(400);
        $this->image->setHeight(100);

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(100, $this->image->getWidth());
    }

    public function testMaterialize()
    {
        $image = imagecreatetruecolor(100, 100);
        $modifier = new GD;
        $this->image->setData($image, $modifier);

        // buffer and return image
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();

        $this->assertEquals($contents, $modifier->materialize($this->image));
    }
}
