<?php declare(strict_types=1);

namespace jeremiahwinsley\framework;

class NativeSession implements SessionInterface
{
    public function __construct()
    {
        (session_status() == PHP_SESSION_ACTIVE) or session_start();
    }

    /**
     * @param string $key
     * @return bool
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * @param array $data
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function fill(array $data)
    {
        $_SESSION = $data;
    }

    public function regenerate()
    {
        session_regenerate_id(true);
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function destroy()
    {
        $_SESSION = array();
        session_destroy();
        $this->__construct();
    }
}