<?php
namespace Hitch\Storage;

use Hitch\Image;

class File implements StorageInterface
{
    protected $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function store(Image $image, $relativePath)
    {
        $materializer = $image->getMaterializer();
        $data = $materializer->materialize($image);

        $path = $this->root . DIRECTORY_SEPARATOR . $relativePath;
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $data);
    }
}
