<?php
namespace Hitch\Modification;

use Hitch\Image;
use Hitch\MaterializationInterface;

class GD implements ModificationInterface, MaterializationInterface
{
    protected function load(Image &$image)
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

    public function materialize(Image $image)
    {
    }
}
