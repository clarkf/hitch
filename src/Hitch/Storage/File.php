<?php
namespace Hitch\Storage;

use Hitch\Image;

class File implements StorageInterface
{
    public function store(Image $image, $path)
    {
        $materializer = $image->getMaterializer();
        $data = $materializer->materialize($image);

        file_put_contents($path, $data);
    }
}
