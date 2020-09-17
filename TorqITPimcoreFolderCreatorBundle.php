<?php

namespace TorqIT\PimcoreFolderCreatorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class TorqITPimcoreFolderCreatorBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/torqitpimcorefoldercreator/js/pimcore/startup.js'
        ];
    }
}