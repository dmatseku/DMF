<?php


namespace   lib\Base\Database;


class   Row
{
    private $attributes = [];

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __unset($name)
    {
        unset($this->attributes[$name]);
    }

    public function getKeyString()
    {
        return implode(', ', array_keys($this->attributes));
    }

    public function getValueString()
    {
        return implode(', ', array_values($this->attributes));
    }

    public function getKeyArray()
    {
        return array_keys($this->attributes);
    }

    public function getValueArray()
    {
        return array_values($this->attributes);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attrs)
    {
        array_merge($this->attributes, $attrs);
    }
}