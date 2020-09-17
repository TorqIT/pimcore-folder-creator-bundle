pimcore.registerNS("pimcore.plugin.TorqITPimcoreFolderCreatorBundle");

pimcore.plugin.TorqITPimcoreFolderCreatorBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TorqITPimcoreFolderCreatorBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("TorqITPimcoreFolderCreatorBundle ready!");
    }
});

var TorqITPimcoreFolderCreatorBundlePlugin = new pimcore.plugin.TorqITPimcoreFolderCreatorBundle();
