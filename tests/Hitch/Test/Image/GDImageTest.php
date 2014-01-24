<?php
namespace Hitch\Test\Image;
// @codingStandardsIgnoreFile

use Hitch\Test\TestCase;
use Hitch\Image\GDImage;

class GDImageTest extends TestCase
{
    public function testItExtendsImage()
    {
        $this->assertInstanceOf("Hitch\Image\Image", new GDImage(""));
    }

    public function testItCanDetermineItsType()
    {
        $image = new GDImage(__DIR__ . "/fixtures/image.png");
        $this->assertEquals(GDImage::TYPE_PNG, $image->getType());

        $image = new GDImage(__DIR__ . "/fixtures/image.jpg");
        $this->assertEquals(GDImage::TYPE_JPG, $image->getType());

        $image = new GDImage(__DIR__ . "/fixtures/image.gif");
        $this->assertEquals(GDImage::TYPE_GIF, $image->getType());

        // Test that for non-image files, it returns null
        $image = new GDImage(__FILE__);
        $this->assertNull($image->getType());
    }
}
