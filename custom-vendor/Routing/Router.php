<?php

namespace Mordor\Storage\Routing;

use InvalidArgumentException;
use Mordor\Storage\Routing\Exception\MissingRouteException;

class Router
{
    public function __construct(
        private array $routes = [],
    ) {
        $this->checkRoutes();
    }

    private function checkRoutes(): void
    {
    }

    public function add(Route $route): void
    {
        $this->routes[$route->getName()] = $route;
    }

    public function has(string $name): bool
    {
        return isset($this->routes[$name]);
    }

    public function get(string $name): Route
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Route with name %s not found.', $name));
        }

        return $this->routes[$name];
    }

    /**
     * @throws MissingRouteException
     */
    public function match(string $url, string $method): Route
    {
        foreach ($this->routes as $route) {
            if (!$route instanceof Route) {
                continue;
            }

            if ($route->match($url) && in_array($method, $route->getEnabledMethods())) {
                return $route;
            }
        }

        throw new MissingRouteException($url, $method);
    }
}