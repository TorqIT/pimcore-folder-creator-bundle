<?php

namespace TorqIT\PimcoreFolderCreatorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class PimcoreFolderCreatorBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/pimcorefoldercreator/js/pimcore/startup.js'
        ];
    }
}