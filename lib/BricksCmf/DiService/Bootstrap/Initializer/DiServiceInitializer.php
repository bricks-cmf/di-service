<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\DiService\Bootstrap\Initializer;

use BricksCmf\DiService\DiService;
use BricksCmf\FactoryService\FactoryService;
use BricksFramework\Bootstrap\Initializer\AbstractInitializer;
use BricksCmf\ConfigService\ConfigService;
use BricksFramework\Bootstrap\BootstrapInterface;
use BricksFramework\Config\Config;

class DiServiceInitializer extends AbstractInitializer
{
    public function initialize(BootstrapInterface $bootstrap): void
    {
        if (in_array(DiService::SERVICE_NAME, $bootstrap->getServices())) {
            return;
        }

        $configService = $bootstrap->getService(ConfigService::SERVICE_NAME)
            ?: $bootstrap->getInstance('BricksCmf\\Config\\Config', [
                'config' => $bootstrap->getInstance('BricksFramework\\Config\\Config')
            ]);
        $config = $configService->getConfig();

        $di = $bootstrap->getInstance('BricksFramework\\Di\\Di', [
            'container' => $bootstrap->getContainer()
        ]);

        $serviceLocator = $bootstrap->getInstance('BricksFramework\\ServiceLocator\\ServiceLocator');

        $factoryService = $bootstrap->getService(FactoryService::SERVICE_NAME)
            ?: $bootstrap->getInstance('BricksCmf\\FactoryService\\FactoryService');

        $diService = $bootstrap->getInstance('BricksCmf\\DiService\\DiService', [
            'config' => $config,
            'di' => $di,
            'serviceLocator' => $serviceLocator,
            'factoryService' => $factoryService
        ]);
        $bootstrap->setService(DiService::SERVICE_NAME, $diService);
    }

    public function getPriority(): int
    {
        return -9300;
    }
}
