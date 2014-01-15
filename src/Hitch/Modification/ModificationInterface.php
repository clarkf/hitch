<?php
namespace Hitch\Modification;

use Hitch\Image;

interface ModificationInterface
{
    public function resize(Image $image, $width, $height);
}
