<?php
namespace Hitch\Test;

use Hitch\Uploader;
use Mockery as m;

class UploaderTest extends TestCase
{
    public function setup()
    {
        $this->modifier = m::mock('Hitch\Modification\ModificationInterface');
        $this->storage = m::mock('Hitch\Storage\StorageInterface');
        $this->file = m::mock('Symfony\Component\HttpFoundation\File\File');
    }

    public function testGetStorageAdapterReturnsStorageAdapters()
    {
        $uploader = new Uploader;

        $storages = $uploader->getStorageAdapters();

        $this->assertTrue(is_array($storages));

        $this->assertGreaterThanOrEqual(1, count($storages));

        foreach ($storages as $storage) {
            $this->assertInstanceOf('Hitch\Storage\StorageInterface', $storage);
        }
    }

    public function testGetModificationInterface()
    {
        $uploader = new Uploader;

        $this->assertInstanceOf(
            'Hitch\Modification\ModificationInterface',
            $uploader->getModificationAdapter()
        );
    }

    public function testGetVersionsReturnsArray()
    {
        $uploader = new Uploader;

        $this->assertTrue(is_array($uploader->getVersionDescriptions()));
    }

    public function testMakeVersionsUsesModifier()
    {
        $uploader = new SimpleUploader;
        $uploader->modifier = $this->modifier;
        $image = m::mock('Hitch\Image');

        $this->modifier->shouldReceive('resize')->once()
            ->with(m::type('Hitch\Image'), 100, 100)
            ->andReturn($image);

        $uploader->makeVersions($image);
    }

    public function testMakeVersionsReturnsHash()
    {
        $uploader = new SimpleUploader;
        $uploader->modifier = $this->modifier;
        $image = m::mock('Hitch\Image');

        $this->modifier->shouldReceive('resize')->once()
            ->andReturn($image);

        $result = $uploader->makeVersions($image);

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('thumb', $result);
        $this->assertEquals($image, $result['thumb']);
    }

    public function testStoreUsesStorageAdapter()
    {
        $uploader = new SimpleUploader;
        $images = array(
            'thumb' => m::mock('Hitch\Image')
        );
        $uploader->modifier = $this->modifier;
        $uploader->storage = array($this->storage);

        $this->modifier->shouldReceive('resize')
            ->andReturn($images['thumb']);

        $this->storage->shouldReceive('store')->once()
            ->with(m::type('Hitch\Image'), m::any());

        $uploader->store($this->file);
    }

    public function testStoreCalculatesVersionPath()
    {
        $uploader = new SimpleUploader;
        $images = array(
            'thumb' => m::mock('Hitch\Image')
        );
        $uploader->modifier = $this->modifier;
        $uploader->storage = array($this->storage);
        $uploader->path = uniqid();

        $this->modifier->shouldReceive('resize')
            ->andReturn($images['thumb']);

        $this->storage->shouldReceive('store')->once()
            ->with(m::any(), $uploader->path);

        $uploader->store($this->file);
    }
}

class SimpleUploader extends Uploader
{
    public $modifier;

    public $storage;

    public $path;

    public function getModificationAdapter()
    {
        return $this->modifier;
    }

    public function getStorageAdapters()
    {
        return $this->storage;
    }

    public function getVersionPath($name)
    {
        return isset($this->path) ? $this->path : parent::getVersionPath($name);
    }

    public function getVersionDescriptions()
    {
        return array(
            'thumb' => array(
                'resize' => array(100, 100)
            )
        );
    }
}
