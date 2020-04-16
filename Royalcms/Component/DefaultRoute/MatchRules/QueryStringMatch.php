<?php

namespace Royalcms\Component\DefaultRoute\MatchRules;


/**
 * Class QueryStringMatch
 * @package Royalcms\Component\DefaultRoute\MatchRules
 */
class QueryStringMatch implements RouteMatchInterface
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
     * 默认query_string参数路由支持
     * index.php?m=admincp&c=index&a=init
     */
    public function handle()
    {
        if (($this->route->getRequest()->input($moduleName)) !== false) {

            $moduleName     = config('route.module', 'm');
            $controllerName = config('route.controller', 'c');
            $actionName     = config('route.action', 'a');

            $module = $request->input($moduleName, $this->route->matchDefaultRoute($moduleName));
            $controller = $request->input($controllerName, $this->route->matchDefaultRoute($controllerName));
            $action = $request->input($actionName, $this->route->matchDefaultRoute($actionName));

            $this->route->setModule($module);
            $this->route->setController($controller);
            $this->route->setAction($action);

            return true;
        }

        return false;
    }
}