<?php
namespace Hitch;

use Symfony\Component\HttpFoundation\File\File;

class Image
{
    /**
     * Make a new Image instance.
     *
     * @param File $file The original image file
     *
     * @return Image A new image instance
     */
    public static function make(File $file)
    {
        $image = new self;

        $image->setOriginalPath((string) $file);
        return $image;
    }

    /**
     * @var mixed Data from a ModificationInterface
     */
    protected $data;

    /**
     * @var string The original path of the image file
     */
    protected $originalPath;

    /**
     * @var integer The image's width
     */
    protected $width = -1;

    /**
     * @var integer The image's height
     */
    protected $height = -1;

    /**
     * Set arbitrary data on the Image
     *
     * @param mixed $data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get the associated data
     *
     * @return mixed The data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the original path
     *
     * @param string $originalPath The original path
     *
     * @return void
     */
    public function setOriginalPath($originalPath)
    {
        $this->originalPath = $originalPath;
    }

    /**
     * Get the path of the original file
     *
     * @return string The original path.
     */
    public function getOriginalPath()
    {
        return $this->originalPath;
    }

    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = (int) $height;
    }

    public function getHeight()
    {
        return $this->height;
    }
}
