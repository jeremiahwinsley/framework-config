<?php declare(strict_types=1);

namespace jeremiahwinsley\framework;

interface SessionInterface
{
    public function get(string $key);

    public function set(string $key, $value);

    public function fill(array $all);

    public function has(string $key): bool;

    public function destroy();

    public function regenerate();
}