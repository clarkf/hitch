# Hitch

[![Build Status](https://travis-ci.org/clarkf/hitch.png?branch=master)](https://travis-ci.org/clarkf/hitch)
[![Latest Stable Version](https://poser.pugx.org/clarkf/hitch/v/stable.png)](https://packagist.org/packages/clarkf/hitch)
[![Dependency Status](https://www.versioneye.com/user/projects/52d6d684ec137507080009a2/badge.png)](https://www.versioneye.com/user/projects/52d6d684ec137507080009a2)
[![Coverage Status](https://coveralls.io/repos/clarkf/hitch/badge.png)](https://coveralls.io/r/clarkf/hitch)



__Table of Contents__

1. [Installation](#installation)
2. [Use](#use)
    1. [Configuration](#configuration)
        1. [Version Descriptions](#version-descriptions)
        2. [Storage Adapters](#storage-adapters)
    2. [Uploading](#uploading)

## Installation

Add the following to your `composer.json` file's `require` property:
```JSON
    "clarkf/hitch": "@dev-master"
```

___Note___: Hitch is currently alpha software.  Requiring `@dev-master`
will load Hitch into your project, but will not guarantee stability.
Use at your own risk.  Or wait until a version is tagged.

## Use

### Configuration

Instantiate a new `Hitch\Uploader` for each image type you'd like to
manage.  It's suggested that you extend the class to provide your own
configuration:

```PHP
class ImageUploader extends \Hitch\Uploader
{
    public function getBaseDir()
    {
        // Override getBaseDir() to provide the folder you'd like to
        // store this image type in.
        return "images/covers";
    }

    public function getVersionDescriptions()
    {
        // Provide your own version descriptions here
    }

    public function getStorageAdapters()
    {
        // Provide your own storage adapter(s) here
    }
}
```

#### Version Descriptions

A version description is simply a description of what processes an image
needs to go through in order to be deemed a specific 'version' of an
image.  For example, for an image to be considered a thumbnail, it needs
to be resized down to a specific size (say, 100x100):

```PHP
public function getVersionDescriptions()
{
    return array(
        'thumb' => array(
            'resize' => array(100, 100)
        )
    );
}
```

#### Storage Adapters
A storage adapter is a mechanism that stores an image somewhere.
Currently, the only adapter shipped is the `Hitch\Storage\File`, which
writes the image to your local filesystem.

Say we want to store all images in `./public/media`, and we want each
image in a dated subdirectory:

```PHP
class ImageUploader extends \Hitch\Uploader
{
    public function getStorageAdapters()
    {
        return array(
            // The first parameter passed to the constructor here is the
            // 'base directory' in which to store all media
            new \Hitch\Storage\File('./public/media')
        );
    }

    public function getBaseDir()
    {
        return date('Y-m-d') . '/';
    }
}
```

If you then upload `mygreatjpeg.jpg`, it would end up at
`./public/media/2014-01-15/mygreatjpeg.jpg` (assuming that today is
January 15th).

### Uploading

To upload a file and generate all requisite versions, you must simply
pass a `Symfony\Component\HttpFoundation\File\File` instance to your
uploader's `store` method.

In the example below, we have some sort of an ORM-style Model class,
that uses custom setters patterned after `setXXXAttribute()`:

```PHP
use Symfony\Component\HttpFoundation\File\File;

class MyModel extends BaseModelClass
{
    protected $uploader;

    public function __construct(/* ... */)
    {
        // ...
        $this->uploader = new ImageUploader;
        // ...
    }

    // ...

    /**
     * Set this instance's `file` attribute (i.e. $model->file = $file).
     * 
     * @param File $file The input file
     * 
     * @return void
     */
    public function setImageAttribute(File $file)
    {
        $this->uploader->store($file);
    }

    // ...
}
```

And that's it!
