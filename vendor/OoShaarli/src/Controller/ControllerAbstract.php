<?php
namespace Shaarli\Controller;

use \Rain;

abstract class ControllerAbstract
{
    protected $view;
    protected $params;
    protected $config;
    protected $database;

    public function __get($key)
    {
        return (isset($this->params[$key])) ? $this->params[$key] : null;
    }

    public function __set($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function __construct()
    {
        $this->setConfig();
        $this->setDatabase();
        $this->view = new \Rain\Tpl();
    }

    protected function setConfig()
    {

    }

    protected function setDatabase()
    {

    }
}
