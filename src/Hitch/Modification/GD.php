<?php
namespace Hitch\Modification;

use Hitch\Image\GDImage as Image;

class GD implements ModificationInterface
{
    /**
     * Resize an image.
     *
     * @param Image   $image  The image to resize
     * @param integer $width  The intended width
     * @param integer $height The intended height
     *
     * @return void
     */
    public function resize(Image $image, $width, $height)
    {
        $resource = $image->getResource();

        $newCanvas = imagecreatetruecolor($width, $height);
        imagecopyresized(
            $newCanvas,
            $resource,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $image->getWidth(),
            $image->getHeight()
        );

        $image->setResource($newCanvas);
    }

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
    public function resizeKeepAspect(Image $image, $width, $height)
    {
        $originalWidth = $image->getWidth();
        $originalHeight = $image->getHeight();

        if ($originalWidth >= $originalHeight) {
            // Image is larger horizontally
            $scale = $width / $originalWidth;
            $height = $originalHeight * $scale;
        } else {
            // Image is larger vertically
            $scale = $height / $originalHeight;
            $width = $originalWidth * $scale;
        }

        return $this->resize($image, $width, $height);
    }
}
