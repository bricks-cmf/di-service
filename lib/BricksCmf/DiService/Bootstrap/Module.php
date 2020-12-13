<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\DiService\Bootstrap;

use BricksCmf\DiService\Bootstrap\Initializer\DiServiceInitializer;
use BricksFramework\Bootstrap\Module\AbstractModule;

class Module extends AbstractModule
{
    public function getInitializerClasses(): array
    {
        return [
            DiServiceInitializer::class
        ];
    }
}
