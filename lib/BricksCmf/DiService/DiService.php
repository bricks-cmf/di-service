<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\DiService;

use BricksFramework\Alias\Alias;
use BricksFramework\Config\ConfigInterface;
use BricksFramework\Di\DiInterface;
use BricksFramework\ServiceLocator\ServiceLocatorInterface;

class DiService implements DiServiceInterface
{
    const SERVICE_NAME = 'bricks/di';

    /** @var ConfigInterface */
    protected $config;

    /** @var DiInterface */
    protected $di;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function __construct(
        ConfigInterface $config,
        DiInterface $di,
        ServiceLocatorInterface $serviceLocator
    ) {
        $this->config = $config;
        $this->di = $di;
        $this->serviceLocator = $serviceLocator;
    }

    public function getService(string $serviceName) : ?object
    {
        return $this->serviceLocator->get($serviceName);
    }

    public function setService(string $serviceName, object $service) : void
    {
        $this->serviceLocator->set($serviceName, $service);
    }

    public function get(string $class, array $arguments = []): object
    {
        $solvedClass = $this->solveAlias($class);
        return $this->di->get($solvedClass, $arguments);
    }

    public function solveAlias(string $class) : string
    {
        $alias = $this->createAlias();
        return $alias->get($class);
    }

    protected function createAlias()
    {
        $alias = new Alias();
        foreach ($this->config->get('bricks/di.aliases') ?: [] as $key => $value) {
            $alias->set($key, $value);
        }
        return $alias;
    }
}
