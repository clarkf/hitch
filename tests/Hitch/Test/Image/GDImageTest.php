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
}
