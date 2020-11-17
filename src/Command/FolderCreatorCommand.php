<?php

namespace TorqIT\PimcoreFolderCreatorBundle\Command;

use Pimcore\Config;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Pimcore\Model\Asset;
use \Pimcore\Model\Document;
use \Pimcore\Model\DataObject;

class FolderCreatorCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('torq:folder-creator')
            ->setDescription('Command for creating the layout of the Pimcore folder structure in the admin interface.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folderFileLocation = PIMCORE_APP_ROOT . '/config/folders.yml';
        $myConfig = new Config();
        $folderStructureArray = $myConfig->getConfigInstance($folderFileLocation, true);

        if($folderStructureArray["system_folders"]){
            $systemFolders = $folderStructureArray["system_folders"];

            if($systemFolders["documents"]){
                $rootDocumentFolder = Document::getByPath("/");
                $this->loopThroughFolders($systemFolders["documents"], $rootDocumentFolder, "createDocumentFolderIfNotExist");
            }

            if($systemFolders["assets"]){
                $rootAssetFolder = Asset::getByPath("/");
                $this->loopThroughFolders($systemFolders["assets"], $rootAssetFolder, "createAssetFolderIfNotExist");
            }

            if($systemFolders["data_objects"]){
                $rootDataObjectFolder = DataObject::getByPath("/");
                $this->loopThroughFolders($systemFolders["data_objects"], $rootDataObjectFolder, "createDataObjectFolderIfNotExist");
            }
        }
    }

    function loopThroughFolders($folders, $parent, $createFolderFunction)
    {
        foreach ($folders as $folder) {
            if(is_string($folder)){
                $this->$createFolderFunction($parent, $folder);
            }
            else if(is_array($folder)){
                foreach($folder as $folderName => $innerFolders){
                    $createdFolder = $this->$createFolderFunction($parent, $folderName);
                    $this->loopThroughFolders($innerFolders, $createdFolder, $createFolderFunction);
                }
            }
        }
    }

    function createDocumentFolderIfNotExist($parentObject, $folderName)
    {
        $documentFolder = Document::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$documentFolder) {
            $documentFolder = new \Pimcore\Model\Document\Folder();
            $documentFolder->setKey($folderName);
            $documentFolder->setParentId($parentObject->getId());
            $documentFolder->save();
        }

        return $documentFolder;
    }

    function createAssetFolderIfNotExist($parentObject, $folderName)
    {
        $assetFolder = Asset::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$assetFolder) {
            $assetFolder = new \Pimcore\Model\Asset\Folder();
            $assetFolder->setFilename($folderName);
            $assetFolder->setParentId($parentObject->getId());
            $assetFolder->save();
        }

        return $assetFolder;
    }

    function createDataObjectFolderIfNotExist($parentObject, $folderName)
    {
        $dataObjectFolder = DataObject::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$dataObjectFolder) {
            $dataObjectFolder = new \Pimcore\Model\DataObject\Folder();
            $dataObjectFolder->setKey($folderName);
            $dataObjectFolder->setParentId($parentObject->getId());
            $dataObjectFolder->save();
        }

        return $dataObjectFolder;
    }
}