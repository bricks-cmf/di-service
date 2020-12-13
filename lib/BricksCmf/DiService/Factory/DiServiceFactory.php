<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\DiService\Factory;

use BricksCmf\ConfigService\Config\ConfigNamespacedInterface;
use BricksCmf\DiService\DiService;
use BricksCmf\ConfigService\Factory\ConfigServiceFactory;
use BricksFramework\Container\PsrContainer;
use BricksFramework\Di\Di;
use BricksFramework\Di\DiInterface;
use BricksFramework\Factory\Factory;
use BricksFramework\ServiceLocator\ServiceLocator;
use BricksFramework\ServiceLocator\ServiceLocatorInterface;

class DiServiceFactory extends Factory
{
    public function get(PsrContainer $container, string $class, array $arguments = []): object
    {
        $config = $this->getConfig($container, $arguments);
        $di = $this->getDi($container, $arguments);
        $serviceLocator = $this->getServiceLocator($container, $arguments);

        if ($container->has('bricks/boostrap')) {
            $bootstrap = $container->get('bricks/bootstrap');
            $diService = $bootstrap->getInstance('BricksCmf\\DiService\\DiService', [
                $config, $di, $serviceLocator
            ]);
        } else {
            $diService = new DiService($config, $di, $serviceLocator);
        }
        
        return $diService;
    }

    protected function getConfig(PsrContainer $container, array $arguments = []) : ConfigNamespacedInterface
    {
        $config = $arguments['config'] ?? false;
        if (!$config) {
            if ($container->has('bricks/bootstrap')) {
                $bootstrap = $container->get('bricks/bootstrap');
                $configServiceFactory = $bootstrap->getInstance('BricksCmf\\ConfigService\\Factory\\ConfigServiceFactory');
                $configService = $configServiceFactory->get($container, 'BricksCmf\\ConfigService\\ConfigService');
            } else {
                $configServiceFactory = new ConfigServiceFactory();
                $configService = $configServiceFactory->get($container, 'BricksCmf\\ConfigService\\ConfigService');
            }
            $config = $configService->getConfig();
        }

        return $config;
    }

    protected function getDi(PsrContainer $container, $arguments = []) : DiInterface
    {
        $di = $arguments['di'] ?? false;
        if (!$di) {
            if ($container->has('bricks/bootstrap')) {
                $bootstrap = $container->get('bricks/bootstrap');
                $di = $bootstrap->getInstance('BricksFramework\\Di\\Di', [
                    $container
                ]);
            } else {
                $di = new Di($container);
            }
        }
        return $di;
    }

    protected function getServiceLocator(PsrContainer $container, array $arguments = []) : ServiceLocatorInterface
    {
        $serviceLocator = $arguments['serviceLocator'] ?? false;
        if (!$serviceLocator) {
            if ($container->has('bricks/bootstrap')) {
                $bootstrap = $container->get('bricks/bootstrap');
                $serviceLocator = $bootstrap->getInstance('BricksFramework\\ServiceLocator\\ServiceLocator');
            } else {
                $serviceLocator = new ServiceLocator();
            }
        }
        return $serviceLocator;
    }
}