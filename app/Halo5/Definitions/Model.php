<?php

namespace App\Halo5\Definitions;

use Illuminate\Contracts\Support\Arrayable;

abstract class Model implements Arrayable, \ArrayAccess
{
    protected $properties = [];
    protected $appends = [];
    protected $cached = [];

    public function __construct(array $properties, array $appends = [])
    {
        foreach ($properties as $key => $property) {
            $this->$key = $property;
        }

        $this->appends = $appends;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function __get($key)
    {
        return $this->getProperty($key);
    }

    public function __set($key, $value)
    {
        $mutator = 's'.studly_case($key);

        if (is_callable([$this, $mutator])) {
            $value = $this->$mutator($value);
        }

        $this->setProperty($key, $value);
    }

    public function __isset($key)
    {
        return isset($this->properties[$key]) || isset($this->cached[$key]);
    }

    public function __unset($key)
    {
        unset($this->properties[$key]);
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

    public function getRawProperty($key)
    {
        return isset($this->properties[$key]) ? $this->properties[$key] : null;
    }

    protected function getProperty($key)
    {
        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $value = (isset($this->properties[$key]) ? $this->properties[$key] : null);
        $mutator = 'g'.studly_case($key);

        if (is_callable([$this, $mutator])) {
            $this->cached[$key] = $value = $this->$mutator($value);
        }

        return $value;
    }

    protected function setProperty($key, $value)
    {
        $this->properties[$key] = $value;
    }

    public function toArray()
    {
        $array = [];
        $properties = array_merge(array_keys($this->properties), $this->appends);
        foreach ($properties as $key) {
            $property = $this->getProperty($key);
            if ($property instanceof Arrayable) {
                $property = $property->toArray();
            }
            $array[$key] = $property;
        }

        return $array;
    }
}
