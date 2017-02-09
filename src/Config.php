<?php declare(strict_types=1);

namespace jeremiahwinsley\framework;

class Config implements \ArrayAccess
{
    protected $config = [];

    public function __construct(string $path)
    {
        if (is_file($path)) {
            $this->config = parse_ini_file($path, true, INI_SCANNER_RAW);
        } else {
            throw new \Exception('Config file not found at ' . $path);
        }

        $info = pathinfo($path);
        $file = sprintf('%s/%s.%s.%s', $info['dirname'], $info['filename'], 'local', $info['extension']);

        if (is_file($file)) {
            $local = parse_ini_file($file, true, INI_SCANNER_RAW);
            $this->config = array_replace_recursive($this->config, $local);
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $conf = $this->config;
        $tok = strtok($key, '.');
        while ($tok !== false) {
            if (!isset($conf[$tok])) {
                return null;
            }
            $conf = $conf[$tok];
            $tok = strtok('.');
        }
        return $conf;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->config[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function offsetSet($offset, $value)
    {
        return;
    }

    /**
     * @param mixed $offset
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function offsetUnset($offset)
    {
        return;
    }
}