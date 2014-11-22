<?php
namespace Shaarli\Controller;

interface FrontControllerInterface
{
    public function setController($controller, $namespace);
    public function setAction($action);
    public function setParams(array $params);
    public function run();
}
