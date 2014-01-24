<?php
namespace Hitch\Image;

class GDImage extends Image
{
    /**
     * @var resource $resource The underlying resource
     */
    protected $resource;

    /**
     * Get the type of the underlying image resource.
     *
     * @return integer The type
     */
    public function getType()
    {
        $data = getimagesize($this->path);
        switch ($data[2]) {
            case IMAGETYPE_PNG:
                return static::TYPE_PNG;
            case IMAGETYPE_JPEG:
                return static::TYPE_JPG;
            case IMAGETYPE_GIF:
                return static::TYPE_GIF;
        }

        // Unknown image type
        return null;
    }

    /**
     * Load the resource from the filesystem
     *
     * @return resource The gd resource
     */
    public function loadResource()
    {
        switch ($this->getType()) {
            case self::TYPE_PNG:
                return imagecreatefrompng($this->path);
                break;
            case self::TYPE_JPG:
                return imagecreatefromjpeg($this->path);
                break;
            case self::TYPE_GIF:
                return imagecreatefromgif($this->path);
                break;
        }
    }

    /**
     * Set the underlying resource
     *
     * @param resource $resource The resource
     *
     * @return void
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get the underlying image resource
     *
     * @return resource The underlying image resource
     */
    public function getResource()
    {
        // Check to see if the resource is unset, in which case we should
        // load it.
        if (!isset($this->resource)) {
            $this->resource = $this->loadResource();
        }

        return $this->resource;
    }

    /**
     * Get the binary contents of the underlying image
     *
     * @return string The binary string containing the contents of the image.
     */
    public function getContents()
    {
        ob_start();
        switch ($this->getType()) {
            case self::TYPE_PNG:
                imagepng($this->getResource());
                break;
            case self::TYPE_JPG:
                imagejpeg($this->getResource());
                break;
            case self::TYPE_GIF:
                imagegif($this->getResource());
                break;
        }
        return ob_get_clean();
    }
}
