<?php
namespace Shaarli\Controller;

class FrontController implements FrontControllerInterface
{
    const DEFAULT_CONTROLLER = 'do';
    const DEFAULT_ACTION = 'index';
    const DEFAULT_NAMESPACE = __NAMESPACE__;

    protected $controller = self::DEFAULT_CONTROLLER;
    protected $action = self::DEFAULT_ACTION;
    protected $namespace = self::DEFAULT_NAMESPACE;

    protected $params = array();
    protected $controllerClass;
    protected $actionMethod;

    public function __construct(array $options = [])
    {
        $this->controllerClass = ucfirst(strtolower($this->controller)).'Controller';
        $this->actionMethod = ucfirst(strtolower($this->action)).'Action';

        if ($options === []) {
            $options = $this->parseUri();
        }

        if (isset($options['controller'])) {
            $this->setController($options['controller'], $this->namespace);
        }

        if (isset($options['action'])) {
            $this->setAction($options['action']);
        }

        if (isset($options['params'])) {
            $this->setParams($options['params']);
        }
    }

    protected function parseUri()
    {
        $request = $_GET;

        $controller = (isset($request['controller'])) ? $request['controller'] : self::DEFAULT_CONTROLLER;
        unset($request['controller']);

        $action = (isset($request[$controller])) ? $request[$controller] : self::DEFAULT_ACTION;
        unset($request[$controller]);

        return [
            'controller' => $controller,
            'action' => $action,
            'params' => $request
        ];
    }

    public function setController($controller, $namespace)
    {
        $controllerClass = $namespace . '\\'. ucfirst(strtolower($controller)).'Controller';
        if (! class_exists($controllerClass)) {
            throw new \InvalidArgumentException("Le controleur '$controller' n'existe pas.");
        }

        $this->controller = $controller;
        $this->controllerClass = $controllerClass;
        return $this;
    }

    public function setAction($action)
    {
        $actionMethod = ucfirst(strtolower($action)).'Action';
        $reflector = new \ReflectionClass($this->controllerClass);
        if (! $reflector->hasMethod($actionMethod)) {
            throw new \InvalidArgumentException("L'action '$action' du controleur '{$this->controller}' n'existe pas.");
        }

        $this->action = $action;
        $this->actionMethod = $actionMethod;

        return $this;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    public function run()
    {
        $controllerClass = $this->controllerClass;
        $controller = new $controllerClass($this->params);
        call_user_func([new $this->controllerClass, $this->actionMethod]);
    }
}
