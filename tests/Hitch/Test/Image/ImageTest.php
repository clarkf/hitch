<?php
namespace Hitch\Test\Image;
// @codingStandardsIgnoreFile

use Hitch\Test\TestCase;
use Hitch\Image\Image;

class ImageTest extends TestCase
{
    public function testItGetsAndSetsDimensions()
    {
        $image = new ConcreteImage("");

        $image->setWidth(100);
        $this->assertEquals(100, $image->getWidth());

        $image->setHeight(200);
        $this->assertEquals(200, $image->getHeight());

        $image->setDimensions(50, 150);
        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(150, $image->getHeight());
    }

    public function testItRemembersTheOriginalPath()
    {
        $expected = uniqid();
        $image = new ConcreteImage($expected);
        $this->assertEquals($expected, $image->getPath());
    }
}

class ConcreteImage extends Image {
    public function getContents() {
        return 'contents';
    }
}
