public function getFilename($original, $version = null)
{
    // Save files with timestamps
    $extension = $original->getExtension();
    return microtime(true) . $extension;
}

public function getVersionPath($original, $version = null)
{
    $filename = $this->getFilename($original, $version);

    // Save versions in their own subdirectory
    if (is_null($version)) {
        return "images/" . $filename;
    } else {
        return "images/" . $version . "/" . $filename;
    }
}
