<?php
namespace Hitch\Image;

abstract class Image
{
    const TYPE_PNG = 1;
    const TYPE_JPG = 2;
    const TYPE_GIF = 3;

    /**
     * @var $width The width
     */
    protected $width;

    /**
     * @var $height The height
     */
    protected $height;

    /**
     * Construct a new File instance
     *
     * @param string  $path   The path of the file
     * @param integer $width  The width of the file
     * @param integer $height The height of the file
     */
    public function __construct($path, $width = -1, $height = -1)
    {
        $this->path = $path;
        $this->setDimensions($width, $height);
    }

    /**
     * Store the width of the image.
     *
     * Note that this does not change the underlying image, just the cached
     * value of the dimensions.
     *
     * @param integer $width The width
     *
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    /**
     * Get the width of the image.
     *
     * @return integer The width of the image
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Store the height of the image.
     *
     * Note that this does not change the underlying image, just the cached
     * value of the dimensions.
     *
     * @param integer $height The height
     *
     * @return void
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }

    /**
     * Get the height of the image.
     *
     * @return integer The height of the image
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Store the dimensions of the image
     *
     * @param integer $width  The width
     * @param integer $height The height
     *
     * @return void
     */
    public function setDimensions($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * Get the path to the image file.
     *
     * @return string The path to the image file
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the binary contents of the underlying image
     *
     * @return string The binary string containing the contents of the image.
     */
    abstract public function getContents();
}
