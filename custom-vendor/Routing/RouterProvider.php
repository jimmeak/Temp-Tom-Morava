<?php

namespace Mordor\Storage\Routing;

use ReflectionClass;

class RouterProvider
{

    // Associative array Class::method => Route
    private array $routes = [];


    public function __construct(
        private string $baseDir = __DIR__ . '/../../src/Controller/',
    ) {
    }

    public function getRouter(): Router
    {
        $router = new Router();

        foreach ($this->routes as $controller => $route) {
            if (!$route instanceof Route) {
                continue;
            }

            $route->setController($controller);
            $router->add($route);
        }

        return $router;
    }

    public function findRoutes(): void
    {
        $phpFiles = glob($this->baseDir . '*.php');

        foreach ($phpFiles as $phpFile) {
            require_once $phpFile;
        }

        echo '<pre>';
        foreach (get_declared_classes() as $class) {
            if (str_contains($class, 'Controller')) {
                $reflectionClass = new ReflectionClass($class);
                $methods = $reflectionClass->getMethods();
                foreach ($methods as $method) {
                    $attributes = $method->getAttributes();
                    foreach ($attributes as $attribute) {
                        if ($attribute->getName() !== Route::class) {
                            continue;
                        }

                        $this->routes[$reflectionClass->getName() . '::' . $method->getName()] = $attribute->newInstance();
                    }
                }

            }
        }

        echo '<pre>';
    }
}
