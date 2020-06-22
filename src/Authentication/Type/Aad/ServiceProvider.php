<?php
namespace Concrete\Package\AzureActiveDirectory\Authentication\Type\Aad;

use OAuth\ServiceFactory;
use OAuth\UserData\ExtractorFactory;

class ServiceProvider extends \Concrete\Core\Foundation\Service\Provider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        // Register our extractor
        $this->app->extend('oauth/factory/extractor', function(ExtractorFactory $factory) {
            $factory->addExtractorMapping(AadService::class, Extractor::class);

            return $factory;
        });

        // Register our service
        $this->app->extend('oauth/factory/service', function(ServiceFactory $factory) {
            $factory->registerService('aad', AadService::class);
            return $factory;
        });
    }
}
