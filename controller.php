<?php
namespace Concrete\Package\CkeditorDeveloperTools;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\Plugin;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle = 'ckeditor_developer_tools';
    protected $appVersionRequired = '8.2.1';
    protected $pkgVersion = '0.9.1';

    public function getPackageName()
    {
        return t('CKEditor Developer Tools');
    }

    public function getPackageDescription()
    {
        return t('Developer tools plugin for CKEditor.');
    }

    public function on_start()
    {
        $this->registerPlugin();
    }

    protected function registerPlugin()
    {
        $assetList = AssetList::getInstance();
        //register our register.js asset
        $assetList->register(
            'javascript',
            'editor/ckeditor/devtools',
            'assets/devtools/register.js',
            [],
            $this->pkgHandle
        );

        //add our register.js asset to a group
        $assetList->registerGroup(
            'editor/ckeditor/devtools',
            [
                ['javascript', 'editor/ckeditor/devtools']
            ]
        );

        //associate our register.js group to the plugin
        $plugin = new Plugin();
        $plugin->setKey('devtools');
        $plugin->setName(t('CKEditor Developer Tools'));
        $plugin->requireAsset('editor/ckeditor/devtools');
        $this->app->make('editor')->getPluginManager()->register($plugin);
    }
}
