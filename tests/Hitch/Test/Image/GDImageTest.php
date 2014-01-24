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

    public function testItCanGetTheResource()
    {
        $image = new GDImage(__DIR__ . "/fixtures/image.png");
        $this->assertTrue(is_resource($image->getResource()));
        $this->assertEquals('gd', get_resource_type($image->getResource()));

        $image = new GDImage(__DIR__ . "/fixtures/image.jpg");
        $this->assertTrue(is_resource($image->getResource()));
        $this->assertEquals('gd', get_resource_type($image->getResource()));

        $image = new GDImage(__DIR__ . "/fixtures/image.gif");
        $this->assertTrue(is_resource($image->getResource()));
        $this->assertEquals('gd', get_resource_type($image->getResource()));

        $image = new GDImage(__FILE__);
        $this->assertNull($image->getResource());
    }

    public function testItWillSetTheResource()
    {
        $resource = imagecreatetruecolor(1, 1);
        $image = new GDImage(__DIR__ . "/fixtures/image.png");

        $image->setResource($resource);
        $this->assertSame($resource, $image->getResource());
    }

    public function testItWillReturnItsContents()
    {
        $image = new GDImage(__DIR__ . "/fixtures/image.png");

        // This sucks.  I hate it.
        $actual = imagecreatefrompng(__DIR__ . "/fixtures/image.png");
        ob_start();
        imagepng($actual);
        $expected = ob_get_clean();

        $this->assertEquals($expected, $image->getContents());
    }
}
