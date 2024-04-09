<?php

namespace Mordor\Storage\DependencyInjection;

use InvalidArgumentException;

class Registry
{
    public function __construct(
        private array $services = [],
    ) {
        foreach ($this->services as $service) {
            if (!is_object($service)) {
                throw new InvalidArgumentException('All services must be an object.');
            }
        }
    }

    public function get(string $id): object
    {
        return $this->services[$id]
            ?? throw new InvalidArgumentException(
                sprintf('Service "%s" not found. Have you had it registered?', $id)
            );
    }

    public function set(string $id, object $service): void
    {
        if ($this->has($id)) {
            throw new InvalidArgumentException(
                sprintf('Service "%s" already exists.', $id)
            );
        }

        $this->services[$id] = $service;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}