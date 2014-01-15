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
        $this->root = dirname($this->path);
        $this->filename = basename($this->path);
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
        $file = new File($this->root);

        $this->materializer->shouldReceive('materialize')->once()
            ->with($this->image);

        $file->store($this->image, $this->filename);
    }

    public function testItWritesToDestination()
    {
        $file = new File($this->root);

        $this->materializer->shouldReceive('materialize')
            ->with($this->image)
            ->andReturn(uniqid());

        $file->store($this->image, $this->filename);
        $this->assertGreaterThan(0, filesize($this->path));
    }

    public function testItWritesDataToDestination()
    {
        $file = new File($this->root);
        $data = 'Hello World!';

        $this->materializer->shouldReceive('materialize')->once()
            ->with($this->image)
            ->andReturn($data);

        $file->store($this->image, $this->filename);

        $this->assertEquals($data, file_get_contents($this->path));
    }

    public function testItWillCreateNecessarySubdirectories()
    {
        $file = new File($this->root);

        $this->materializer->shouldReceive('materialize')
            ->andReturn(uniqid());

        $file->store($this->image, 'pictures/' . $this->filename);

        $this->assertTrue(is_dir($this->root . '/pictures'));
        $this->assertTrue(is_file($this->root . '/pictures/' . $this->filename));

        // cleanup
        unlink($this->root . '/pictures/' . $this->filename);
        rmdir($this->root . '/pictures');
    }
}
