<?php

namespace CarApp\DependencyInjection;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $storage;

    public function set(string $id, callable $dependency)
    {
        $this->storage[$id] = $dependency;
    }

    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->storage[$id]($this);
        }
        throw new \Exception('Dependency not found');
    }

    public function has(string $id): bool
    {
        return isset($this->storage[$id]);
    }
}