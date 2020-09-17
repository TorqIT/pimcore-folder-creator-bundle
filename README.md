# pimcore-admin-folder-creator-bundle

This bundle will use the layout in `folders.yml` to create and save a folder layout in the pimcore admin. It will not delete and remove existing folders. It will check to ensure the folder in the template is at the location it expects.

Steps to setting up the layout of your folder structure in pimcore admin:
1- Update `folders.yml` to the layout you require
2- Run bundle


In order to enable this bundle, you will have to register it as a custom bundle in your `AppKernel.php`. You can than add your bundle similar to this:
`$collection->addBundle(new TorqIT\PimcoreFolderCreatorBundle\TorqITPimcoreFolderCreatorBundle, 10);`
