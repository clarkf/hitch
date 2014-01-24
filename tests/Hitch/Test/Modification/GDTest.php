<?php
namespace Hitch\Test\Modification;
// @codingStandardsIgnoreFile

use Hitch\Test\TestCase;
use Mockery as m;
use Hitch\Modification\GD;
use Hitch\Image\GDImage;

class GDTest extends TestCase
{
    public function setup()
    {
        parent::setup();

        $this->image = new GDImage(__DIR__ . "/fixtures/image.png");
    }

    public function testResizeResizesResource()
    {
        $width = 100;
        $height = 200;
        $modifier = new GD;

        $modifier->resize($this->image, $width, $height);

        $this->assertEquals(100, $this->image->getWidth());
        $this->assertEquals(200, $this->image->getHeight());
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
        $this->image = new GDImage(__DIR__ . "/fixtures/tall.png");

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(100, $this->image->getHeight());
    }

    public function testResizeKeepAspectResizesHorizontally()
    {
        $this->image = new GDImage(__DIR__ . "/fixtures/wide.png");

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(100, $this->image->getWidth());
    }

    public function testResizeKeepAspectResizesOtherDimension()
    {
        $this->image = new GDImage(__DIR__ . "/fixtures/wide.png");

        $modifier = new GD;
        $modifier->resizeKeepAspect($this->image, 100, 100);

        $this->assertEquals(33, $this->image->getHeight());
    }
}
