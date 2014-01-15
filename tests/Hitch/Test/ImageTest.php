<?php
namespace Hitch\Test;

use Hitch\Image;
use Mockery as m;

class ImageTest extends TestCase
{
    public function testItCanStoreArbitraryData()
    {
        $image = new Image;
        $data = uniqid();

        $image->setData($data);
        $this->assertEquals($data, $image->getData());
    }

    public function testItCanBeCreatedFromAFile()
    {
        $file = m::mock("Symfony\Component\HttpFoundation\File\File");
        $file->shouldReceive('__toString')
            ->andReturn(uniqid());
        $image = Image::make($file);

        $this->assertInstanceOf("Hitch\Image", $image);
    }

    public function testItCanStoreOriginalPath()
    {
        $image = new Image;
        $path = uniqid();

        $image->setOriginalPath($path);
        $this->assertEquals($path, $image->getOriginalPath());
    }

    public function testCreationFromFileSetsOriginalPath()
    {
        $path = uniqid();
        $file = m::mock("Symfony\Component\HttpFoundation\File\File");
        $file->shouldReceive('__toString')
            ->andReturn($path);
        $image = Image::make($file);

        $this->assertEquals($path, $image->getOriginalPath());
    }

    public function testItHasWidthAndHeightSettersAndGetters()
    {
        $image = new Image;

        $image->setWidth(10);
        $this->assertEquals(10, $image->getWidth());

        $image->setHeight(20);
        $this->assertEquals(20, $image->getHeight());
    }
}
