<?php

namespace Juxta;

final class Request implements \ArrayAccess
{
    /**
     * @var array
     */
    private $request;

    /**
     * @param array $request
     */
    public function __construct(array $request = null)
    {
        if (!is_null($request)) {
            $this->request = $request;
        }
    }

    /**
     * @param $name
     * @param mixed $default
     * @return string|null
     */
    public function get($name, $default = null)
    {
        if (!array_key_exists($name, $this->request)) {
            return $default;
        }

        return $this->request[$name];
    }

    /**
     * \ArrayAccess::offsetGet()
     *
     * @param mixed $name
     * @return mixed|null
     */
    public function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * \ArrayAccess::offsetSet()
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * \ArrayAccess::offsetUnset()
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * \ArrayAccess::offsetExists()
     *
     * @param mixed $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return isset($this->request[$name]);
    }
}