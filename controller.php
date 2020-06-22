<?php

namespace Concrete\Package\AzureActiveDirectory;

use Concrete\Core\Package\Package;
use Concrete\Core\Authentication\AuthenticationType;
use \Concrete\Package\AzureActiveDirectory\Authentication\Type\Aad\ServiceProvider;
use Loader;

class Controller extends Package
{

    protected $appVersionRequired = '8.1.0';
    protected $pkgVersion = '1.0.0';
    protected $pkgHandle = 'azure_active_directory';
    protected $pkgName = 'Azure Active Directory';
    protected $pkgDescription = 'Authorize with Azure Active DIrectory';
    protected $pkgAutoloaderRegistries = [
        'src' => '\Concrete\Package\AzureActiveDirectory',
    ];


    public function on_start()
    {
        $this->registerAutoload();
        $this->app->make(ServiceProvider::class)->register();
    }

    public function install()
    {
        $this->pkg = parent::install();
        $this->db = Loader::db();

        $this->addAuthenticationType();
    }

    public function upgrade()
    {
        $result = parent::upgrade();
        $this->pkg = Package::getByHandle($this->pkgHandle);
        $this->db = Loader::db();

        $this->addAuthenticationType();

        return $result;
    }

    private function addAuthenticationType()
    {
        $spaList = AuthenticationType::getListByPackage($this->pkg);
        if (count($spaList) == 0) {
            $spa = AuthenticationType::add('aad', t('Azure Active Directory'), 0, $this->pkg);
        } else {
            $spa = AuthenticationType::getByHandle('aad');
        }
        if (!$spa->isEnabled()) {
            $spa->enable();
        }
    }

    private function registerAutoload()
    {
        $autoloader = $this->getPackagePath() . '/vendor/autoload.php';
        if (file_exists($autoloader)) {
            require_once $autoloader;
        }
    }
}
