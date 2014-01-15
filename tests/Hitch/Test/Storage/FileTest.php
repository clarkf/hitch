<?php
namespace Hitch\Test\Storage;

use Hitch\Test\TestCase;
use Mockery as m;
use Hitch\Image;
use Hitch\Storage\File;

class FileTest extends TestCase
{
    public function setup()
    {
        parent::setup();

        $this->materializer = m::mock("Hitch\MaterializationInterface");
        $this->image = new Image;
        $this->image->setData(uniqid(), $this->materializer);

        $this->path = tempnam(sys_get_temp_dir(), 'image_');
    }

    public function teardown()
    {
        if (is_file($this->path)) {
            unlink($this->path);
        }
        parent::teardown();
    }

    public function testItUsesMaterializer()
    {
        $file = new File;

        $this->materializer->shouldReceive('materialize')->once()
            ->with($this->image);

        $file->store($this->image, $this->path);
    }

    public function testItWritesToDestination()
    {
        $file = new File;

        $this->materializer->shouldReceive('materialize')
            ->with($this->image)
            ->andReturn(uniqid());

        $file->store($this->image, $this->path);
        $this->assertGreaterThan(0, filesize($this->path));
    }

    public function testItWritesDataToDestination()
    {
        $file = new File;
        $data = 'Hello World!';

        $this->materializer->shouldReceive('materialize')->once()
            ->with($this->image)
            ->andReturn($data);

        $file->store($this->image, $this->path);

        $this->assertEquals($data, file_get_contents($this->path));
    }
}
