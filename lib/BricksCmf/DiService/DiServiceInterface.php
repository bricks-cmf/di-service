<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/namespace BricksCmf\DiService;

interface DiServiceInterface
{
    public function getService(string $serviceName) : ?object;
    public function setService(string $serviceName, object $service) : void;
    public function get(string $class, array $arguments = []) : object;
    public function solveAlias(string $class) : string;
}