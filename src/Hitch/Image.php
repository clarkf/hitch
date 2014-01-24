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
     * @var MaterializationInterface The materializer associated with $data
     */
    protected $materializer;

    /**
     * Set arbitrary data on the Image
     *
     * @param mixed                    $data         The data to set
     * @param MaterializationInterface $materializer The materializer
     *
     * @return void
     */
    public function setData($data, $materializer)
    {
        $this->data = $data;
        $this->materializer = $materializer;
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
     * Get the {@link MaterializationInterface} associated with the underlying
     * data.
     *
     * @return MaterializationInterface The materializer
     */
    public function getMaterializer()
    {
        return $this->materializer;
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
}
