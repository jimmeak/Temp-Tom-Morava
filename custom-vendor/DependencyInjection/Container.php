<?php

namespace Mordor\Storage\DependencyInjection;

use InvalidArgumentException;
use ReflectionClass;

class Container
{
    public function __construct(
        private readonly Registry $registry,
    ) {
    }

    public function addService(string $id, object $service): void
    {
        $this->registry->set($id, $service);
    }

    public function get(string $fqcn): object
    {
        if ($this->registry->has($fqcn)) {
            return $this->registry->get($fqcn);
        }

        $service = $this->createService($fqcn);
        $this->addService($fqcn, $service);

        return $service;
    }

    // Probably some service provider?
    public function createService(string $fqcn): object
    {
        $reflection = new ReflectionClass($fqcn);

        if (!$reflection->isInstantiable()) {
            throw new InvalidArgumentException(
                sprintf('Service "%s" is not instantiable.', $fqcn)
            );
        }

        if (0 === count($reflection->getConstructor()?->getParameters() ?? [])) {
            return new $fqcn();
        }

        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            if ('string' === $parameter->getType()->getName()) {
                throw new InvalidArgumentException(
                    sprintf('Service "%s" has an invalid type hint.', $fqcn)
                );
            }

            $dependencies[$parameter->getName()] = $this->get($parameter->getType()->getName());
        }

        return new $fqcn(...$dependencies);
    }
}