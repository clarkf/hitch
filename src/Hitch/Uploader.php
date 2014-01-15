<?php
namespace Hitch;

use Symfony\Component\HttpFoundation\File\File;
use Hitch\Storage\File as FileStorage;
use Hitch\Modification\GD as GDModifier;

class Uploader
{
    public function getStorageAdapters()
    {
        return array(new FileStorage);
    }

    public function getModificationAdapter()
    {
        return new GDModifier;
    }

    public function getVersionDescriptions()
    {
        return array();
    }

    public function getVersionPath($name)
    {
        return "";
    }

    public function store(File $file)
    {
        $image = Image::make($file);

        $versions = $this->makeVersions($image);

        foreach ($versions as $name => $version) {
            $path = $this->getVersionPath($name);

            foreach ($this->getStorageAdapters() as $storage) {
                $storage->store($version, $path);
            }
        }
    }

    public function makeVersions(Image $image)
    {
        $versions = array();

        foreach ($this->getVersionDescriptions() as $name => $processes) {
            $version = $this->makeVersion($image, $processes);
            $versions[$name] = $version;
        }

        return $versions;
    }

    public function makeVersion(Image $image, array $processes)
    {
        $modifier = $this->getModificationAdapter();
        $version = clone $image;

        foreach ($processes as $process => $args) {
            array_unshift($args, $version);

            call_user_func_array(array($modifier, $process), $args);
        }

        return $version;
    }
}