<?php

namespace Mordor\Storage\Http;

use Mordor\Storage\DependencyInjection\Container;
use Mordor\Storage\DependencyInjection\Registry;
use Mordor\Storage\Routing\RouterProvider;
use Throwable;

class Kernel
{
    public function run()
    {
        try {
            echo '<pre>';

            $registry = new Registry();
            $container = new Container($registry);

            $request = new Request();

            $routerProvider = new RouterProvider();
            $routerProvider->findRoutes();
            $router = $routerProvider->getRouter();

            $route = $router->match($request->getBasePath(), $request->getRequestMethod());
            $controller = explode('::', $route->getController());

            $controllerClass = $controller[0];
            $controllerMethod = $controller[1];

            $controllerInstance = $container->get($controllerClass);
            $response = $controllerInstance->{$controllerMethod}();

            echo $response;

        } catch (Throwable $e) {
            echo "<h1>Whoops! {$e->getCode()}</h1>";
            echo 'An error occurred: ' . $e->getMessage();
            throw $e;
        }

        echo '<hr>';
        print_r($router ?? null);

    }

}