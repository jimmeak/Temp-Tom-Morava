<?php

namespace Mordor\Storage\List;

use InvalidArgumentException;
use Iterator;

class ArrayList implements Iterator
{
    private int $position = 0;

    protected function __construct(
        protected array $items = [],
    ) {
    }

    public static function new(array $items = []): self
    {
        ksort($items);
        return new self($items);
    }

    public function get(string|int $index, mixed $default = null, bool $throwException = false): mixed
    {
        if ($throwException && !$this->has($index)) {
            throw new InvalidArgumentException("Index $index does not exist in the list.");
        }

        return $this->items[$index] ?? $default;
    }

    public function set(string|int $index, mixed $value): static
    {
        $this->items[$index] = $value;
        ksort($this->items);

        return $this;
    }

    public function has(int $index): bool
    {
        return isset($this->items[$index]);
    }

    public function remove(int $index, bool $throwException = false): void
    {
        if ($this->has($index)) {
            unset($this->items[$index]);
            return;
        }

        if ($throwException) {
            throw new InvalidArgumentException("Index $index does not exist in the list.");
        }
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function first(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->items[array_key_first($this->items)];
    }

    public function last(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->items[array_key_last($this->items)];
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }

    public function values(): array
    {
        return array_values($this->items);
    }

    public function map(callable $callback): static
    {
        return static::new(array_map($callback, $this->items));
    }

    public function filter(callable $callback): static
    {
        return static::new(array_filter($this->items, $callback));
    }

    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}