<?php
namespace Hitch\Image;

class GDImage extends Image
{
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
     * Get the underlying image resource
     *
     * @return resource The underlying image resource
     */
    public function getResource()
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
}
