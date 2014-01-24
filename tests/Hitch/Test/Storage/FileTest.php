<?php
namespace Hitch\Test\Storage;
// @codingStandardsIgnoreFile

use Hitch\Test\TestCase;
use Mockery as m;
use Hitch\Image\GDImage;
use Hitch\Storage\File;

class FileTest extends TestCase
{
    public function setup()
    {
        parent::setup();

        $this->materializer = m::mock("Hitch\MaterializationInterface");
        $this->image = new GDImage(__DIR__ . "/../Modification/fixtures/image.png");
        $this->image->setResource(imagecreatetruecolor(1,1));

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

    public function testItWritesToDestination()
    {
        $file = new File($this->root);


        $file->store($this->image, $this->filename);
        $this->assertGreaterThan(0, filesize($this->path));
    }

    public function testItWritesDataToDestination()
    {
        $file = new File($this->root);

        $file->store($this->image, $this->filename);

        $this->assertEquals($this->image->getContents(), file_get_contents($this->path));
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
