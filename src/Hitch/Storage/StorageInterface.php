<?php
namespace Hitch\Storage;

use Hitch\Image;

interface StorageInterface
{
    public function store(Image $image, $path);
}
