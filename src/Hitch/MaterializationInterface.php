<?php
namespace Hitch;

interface MaterializationInterface
{
    /**
     * Materialize a Hitch\Image. Get the contents of the underlying,
     * modified image asset.
     *
     * @param Image $image The image to materialize
     *
     * @return string The contents of the image
     */
    public function materialize(Image $image);
}
