<?php

namespace TorqIT\FolderCreatorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class FolderCreatorBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/FolderCreator/js/pimcore/startup.js'
        ];
    }
}