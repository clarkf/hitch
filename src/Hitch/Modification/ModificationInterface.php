<?php
namespace Hitch\Modification;

use Hitch\Image;

interface ModificationInterface
{
    public function resize(Image $image, $width, $height);

    /**
     * Resize an image while maintaining the aspect ratio.
     *
     * Note that the returned data will most likely not be `$width`x`$height`,
     * but as close as possible while keeping the original aspect ratio.
     *
     * @param Image   $image  The input image
     * @param integer $width  The maximum width
     * @param integer $height The maximum height
     *
     * @return void
     */
    public function resizeKeepAspect(Image $image, $width, $height);
}
