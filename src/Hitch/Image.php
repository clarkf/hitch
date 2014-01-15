<?php
namespace Hitch;

use Symfony\Component\HttpFoundation\File\File;

class Image
{
    public static function make(File $file)
    {
        return new self;
    }
}
