# pimcore-admin-folder-creator-bundle

This bundle will use the layout in `\src\pimcore-root\app\config\folders.yml` to create and save a folder layout in the pimcore admin. It will not delete and remove existing folders. It will check to ensure the folder in the template is at the location it expects. In the repo, their is an example folders.yml file, with the layout the command expects.

# Installing the package via composer

This bundle is easily installed via composer: `composer require torqit/pimcore-folder-creator-bundle`

# Steps to setting up the layout of your folder structure in pimcore admin:
1. Create a `folders.yml` file, with the layout you require.
2. Place the `folders.yml` file you created in configuration yaml folder like: `\src\pimcore-root\app\config\folders.yml`.
3. Make sure you register the `TorqITFolderCreatorBundle` in your `AppKernel.php` located at `\src\pimcore-root\app\AppKernel.php`. Registering the bundle is as easy as adding a line in the registerBundlesToCollection function, like so: `$collection->addBundle(new \TorqIT\PimcoreFolderCreatorBundle\TorqITPimcoreFolderCreatorBundle);`
4. Run the bundle, with the command: `./bin/console torq-it-folder-creator:folder-creator`
