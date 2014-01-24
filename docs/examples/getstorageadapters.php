public function getStorageAdapters()
{
    $root_path = get_path_of_public_dir();

    return array(
        new \Hitch\Storage\File($root_path)       
    );
}
