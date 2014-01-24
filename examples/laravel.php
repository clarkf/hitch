<?php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model;
use Acme\Uploaders\ImageUploader;
use Symfony\Components\HttpFoundation\File\File;

class Image extends Model
{
    protected $fillable = array(
        /* .. */
        "image",
        /* .. */
    );

    /**
     * @var Hitch\Uploader The uploader
     */
    protected $uploader;

    /**
     * @var File $file The file to upload
     */
    protected $file;

    /**
     * Initialize model events
     *
     * @return void
     */
    public static function boot()
    {
        // Call the parent's boot method
        parent::boot();

        // Attach to this model's 'saved' event.
        self::saved(function ($image) {

            // Check to see if there was an image to upload
            if (!isset($image->image)) {
                return;
            }

            // Pass the File to the Uploader's #store() method
            $image->getUploader()->store($image->image);
        });
    }

    /**
     * Get the uploader associated with this model
     *
     * @return Hitch\Uploader The uploader
     */
    public function getUploader()
    {
        // Check to see if uploader has been initialized.  If it hasn't,
        // initialize it now
        if (!isset($this->uploader)) {
            $this->uploader = new ImageUploader;
        }

        return $this->uploader;
    }

    /**
     * Set the image attribute
     *
     * @param File $file The file to store
     *
     * @return void
     */
    public function setImageAttribute(File $file)
    {
        // Note that we don't want to #store() the file now; the model
        // has not yet passed validation.  For now, we'll just store it
        // until the model has been saved.
        $this->file = $file;
    }
}
