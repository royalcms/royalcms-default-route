<?php

namespace Royalcms\Component\DefaultRoute\MatchRules;


/**
 * Class QueryRMatch
 * @package Royalcms\Component\DefaultRoute\MatchRules
 */
class QueryRMatch implements RouteMatchInterface
{

    /**
     * @var \Royalcms\Component\DefaultRoute\HttpQueryRoute
     */
    protected $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * 参数路由兼容
     * index.php?r=admin/index/init
     */
    public function handle()
    {
        if (($route = $this->route->getRequest()->input($routeName)) !== false) {

            $moduleName     = config('route.module', 'm');
            $controllerName = config('route.controller', 'c');
            $actionName     = config('route.action', 'a');
            $routeName      = config('route.route', 'r');

            list($module, $controller, $action) = explode('/', $route);

            $module = $module ?: $this->matchDefaultRoute($moduleName);
            $controller = $controller ?: $this->matchDefaultRoute($controllerName);
            $action = $action ?: $this->matchDefaultRoute($actionName);

            $this->route->setModule($module);
            $this->route->setController($controller);
            $this->route->setAction($action);

            return true;
        }

        return false;
    }
}