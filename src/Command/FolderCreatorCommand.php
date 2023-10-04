<?php

namespace TorqIT\FolderCreatorBundle\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Pimcore\Model\Asset;
use \Pimcore\Model\Document;
use \Pimcore\Model\DataObject;
use Symfony\Component\Yaml\Yaml;

class FolderCreatorCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('torq:folder-creator')
            ->setDescription('Command for creating the layout of the Pimcore folder structure in the admin interface.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $folderFileLocation = PIMCORE_PROJECT_ROOT . '/config/folders.yaml';
        $folderStructureArray = Yaml::parseFile($folderFileLocation);

        if ($folderStructureArray["system_folders"]) {
            $systemFolders = $folderStructureArray["system_folders"];

            if (isset($systemFolders["documents"])) {
                $rootDocumentFolder = Document::getByPath("/");
                $this->loopThroughFolders($systemFolders["documents"], $rootDocumentFolder, "createDocumentFolderIfNotExist");
            }

            if (isset($systemFolders["assets"])) {
                $rootAssetFolder = Asset::getByPath("/");
                $this->loopThroughFolders($systemFolders["assets"], $rootAssetFolder, "createAssetFolderIfNotExist");
            }

            if (isset($systemFolders["data_objects"])) {
                $rootDataObjectFolder = DataObject::getByPath("/");
                $this->loopThroughFolders($systemFolders["data_objects"], $rootDataObjectFolder, "createDataObjectFolderIfNotExist");
            }
        }

        return 0;
    }

    private function loopThroughFolders($folders, $parent, $createFolderFunction): void
    {
        foreach ($folders as $folder) {
            if (is_string($folder)) {
                if ($folder == '<alphabetical>') {
                    $folder = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                    $this->loopThroughFolders($folder, $parent, $createFolderFunction);
                } else if ($folder == '<numerical>') {
                    $folder = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    $this->loopThroughFolders($folder, $parent, $createFolderFunction);
                } else {
                    $this->$createFolderFunction($parent, $folder);
                }
            } else if (is_array($folder)) {
                foreach ($folder as $folderName => $innerFolders) {
                    $createdFolder = $this->$createFolderFunction($parent, $folderName);
                    $this->loopThroughFolders($innerFolders, $createdFolder, $createFolderFunction);
                }
            }
        }
    }

    private function createDocumentFolderIfNotExist($parentObject, $folderName): Document|Document\Folder
    {
        $documentFolder = Document::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$documentFolder) {
            $documentFolder = new Document\Folder();
            $documentFolder->setKey($folderName);
            $documentFolder->setParentId($parentObject->getId());
            $documentFolder->save();
        }

        return $documentFolder;
    }

    private function createAssetFolderIfNotExist($parentObject, $folderName): Asset|Asset\Folder
    {
        $assetFolder = Asset::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$assetFolder) {
            $assetFolder = new Asset\Folder();
            $assetFolder->setFilename($folderName);
            $assetFolder->setParentId($parentObject->getId());
            $assetFolder->save();
        }

        return $assetFolder;
    }

    private function createDataObjectFolderIfNotExist($parentObject, $folderName): DataObject|DataObject\Folder
    {
        $dataObjectFolder = DataObject::getByPath($parentObject->getFullPath() . "/" . $folderName);

        if (!$dataObjectFolder) {
            $dataObjectFolder = new DataObject\Folder();
            $dataObjectFolder->setKey($folderName);
            $dataObjectFolder->setParentId($parentObject->getId());
            $dataObjectFolder->save();
        }

        return $dataObjectFolder;
    }
}
