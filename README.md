# pimcore-admin-folder-creator-bundle

This bundle will use the layout in `config/folders.yaml` to create and save a folder layout in the pimcore admin. It will not delete and remove existing folders. It will check to ensure the folder in the template is at the location it expects. In the repo, their is an example `folders.yaml` file, with the layout the command expects.

# Installing the package via composer

This bundle is easily installed via composer: `composer require torqit/pimcore-folder-creator-bundle`

# Steps to setting up the layout of your folder structure in pimcore admin:

1. Create a `folders.yaml` file, with the layout you require.
2. Place the `folders.yaml` file you created in configuration yaml folder: `config/folders.yaml`.
3. Make sure you register the `FolderCreatorBundle` in your `Kernel.php`. Registering the bundle is as easy as adding a line in the registerBundlesToCollection function, like so: `$collection->addBundle(new \TorqIT\FolderCreatorBundle\FolderCreatorBundle);`.
4. Run the bundle, with the command: `./bin/console torq:folder-creator`
