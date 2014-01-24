<?php
namespace Hitch\Modification;

use Hitch\Image;
use Hitch\MaterializationInterface;

class GD implements ModificationInterface, MaterializationInterface
{
    /**
     * Load an image from a file into memory.
     *
     * @param Image $image The image to load
     *
     * @return void
     */
    protected function load(Image $image)
    {
        $path = $image->getOriginalPath();
        $data = getimagesize($path);
        list($width, $height, $type) = $data;

        $image->setWidth($width);
        $image->setHeight($height);

        switch ($type)
        {
            case IMAGETYPE_PNG:
                $resource = imagecreatefrompng($path);
                break;
            case IMAGETYPE_JPEG:
                $resource = imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_GIF:
                $resource = imagecreatefromgif($path);
                break;
            default:
                throw new InvalidArgumentException(
                    "Unable to handle image: " . $path
                );
        }

        $image->setData($resource, $this);
    }

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
        if (!$image->getData()) {
            $this->load($image);
        }

        $resource = $image->getData();

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

        $image->setData($newCanvas, $this);
        $image->setWidth($width);
        $image->setHeight($height);
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

    /**
     * Materialize an image.
     *
     * @param Image $image The image to materialize
     *
     * @return string The materialized image
     */
    public function materialize(Image $image)
    {
        $imageHandle = $image->getData();

        // Buffer the output, and output the image data to it
        ob_start();
        imagepng($imageHandle);

        // Return the outputted image data
        return ob_get_clean();
    }
}
