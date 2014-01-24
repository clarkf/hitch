<?php
namespace Hitch;

use Symfony\Component\HttpFoundation\File\File;
use Hitch\Storage\File as FileStorage;
use Hitch\Modification\GD as GDModifier;
use Hitch\Image\Image;
use Hitch\Image\GDImage;

class Uploader
{
    /**
     * Return an array of Storage Adapters.  All files will be saved to all
     * storage adapters.
     *
     * @return Hitch\Storage\StorageInterface[]
     */
    public function getStorageAdapters()
    {
        return array(new FileStorage(sys_get_temp_dir()));
    }

    /**
     * Get the Modification Adapter
     *
     * @return Hitch\Modification\ModificationInterface
     */
    public function getModificationAdapter()
    {
        return new GDModifier;
    }

    /**
     * Return the version descriptions.
     *
     * Version descriptions are a key/value array, where the key signifies
     * the 'name' of the version, and the value is an array of processes.
     *
     * A process is a key/value pair where the key represents the name of the
     * process, and the value is an array of parameters to pass to the
     * processor.
     *
     * @return array The version descriptions
     *
     * @see Hitch\Modification\ModificationInterface
     */
    public function getVersionDescriptions()
    {
        return array();
    }

    /**
     * Get the base directory for storing all images.
     *
     * Note that this will be appended to the StorageInterface's configured
     * base path.  This only allows you to store images within an uploader
     * in separate subdirectories.
     *
     * @return string The base directory
     */
    public function getBaseDir()
    {
        return "images/";
    }

    /**
     * Calculate the filename of the resultant file or version.
     *
     * @param File        $original The original file
     * @param string|null $version  The name of the version, or null
     *
     * @return string The resultant filename
     */
    public function getFilename(File $original, $version = null)
    {
        if (is_null($version)) {
            return $original->getBasename();
        }

        $extension = $original->getExtension();
        $base = $original->getBasename($extension);
        return $base . $version . '.' . $extension;
    }

    /**
     * Calculate the relative path for a specified file
     *
     * @param File        $original The original file
     * @param string|null $version  The name of the version
     *
     * @return string The relative path of the file
     */
    public function getVersionPath(File $original, $version = null)
    {
        return $this->getBaseDir() . $this->getFilename($original, $version);
    }

    /**
     * Store a file.
     *
     * @param File $file The file to store
     *
     * @return void
     */
    public function store(File $file)
    {
        $image = new GDImage((string) $file);

        $versions = $this->makeVersions($image);

        foreach ($versions as $name => $version) {
            $path = $this->getVersionPath($file, $name);

            foreach ($this->getStorageAdapters() as $storage) {
                $storage->store($version, $path);
            }
        }
    }

    /**
     * Generate the versions of the image specified by getVersionDescriptions().
     *
     * @param Image $image The image
     *
     * @return array A key/value array containing the versions
     */
    public function makeVersions(Image $image)
    {
        $versions = array();

        foreach ($this->getVersionDescriptions() as $name => $processes) {
            $version = $this->makeVersion($image, $processes);
            $versions[$name] = $version;
        }

        return $versions;
    }

    /**
     * Make a single version. Returns a new image with the changes made.
     *
     * @param Image $image     The image to modify
     * @param array $processes The processes to apply to the image
     *
     * @return Image the resultant image.
     */
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
