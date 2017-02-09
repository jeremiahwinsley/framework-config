<?php declare(strict_types=1);

namespace jeremiahwinsley\framework;

class MockSession implements SessionInterface
{
    protected $data = [];
    protected $token;

    public function get(string $key)
    {
        return $this->has($key) ? $this->data[$key] : false;
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    public function fill(array $data)
    {
        $this->data = $data;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function destroy()
    {
        $this->data = [];
    }

    public function regenerate()
    {
        return true;
    }
}