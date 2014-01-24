<?php
namespace Hitch\Storage;

use Hitch\Image\Image;

interface StorageInterface
{
    /**
     * Store an image in this File StorageInterface.
     *
     * @param Image  $image        The image to store.
     * @param string $relativePath The path, relative to the intialized root,
     *                             to store the image at.
     *
     * @return void
     */
    public function store(Image $image, $relativePath);
}
