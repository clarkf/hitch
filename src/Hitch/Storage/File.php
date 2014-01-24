<?php
namespace Hitch\Storage;

use Hitch\Image\Image;

class File implements StorageInterface
{
    protected $root;

    /**
     * Construct a new File StorageInterface.
     *
     * @param string $root The root directory used for storage
     *
     * @return void
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * Store an image in this File StorageInterface.
     *
     * @param Image  $image        The image to store.
     * @param string $relativePath The path, relative to the intialized root,
     *                             to store the image at.
     *
     * @return void
     */
    public function store(Image $image, $relativePath)
    {
        $data = $image->getContents();

        $path = $this->root . DIRECTORY_SEPARATOR . $relativePath;
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $data);
    }
}
