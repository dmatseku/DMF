<?php


namespace   lib\Base\Database;


class   Row
{
    /**
     * @var array array of new variables
     */
    private array $attributes = [];

    public function __set($name, $value): void
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

    /**
     * get string of names of attributes
     *
     * @return string
     */
    public function getKeyString()
    {
        return implode(', ', array_keys($this->attributes));
    }

    /**
     * get string of values of attributes
     *
     * @return string
     */
    public function getValueString()
    {
        return implode(', ', array_values($this->attributes));
    }

    /**
     * get array of names of attributes
     *
     * @return array
     */
    public function getKeyArray()
    {
        return array_keys($this->attributes);
    }

    /**
     * get string of values of attributes
     *
     * @return array
     */
    public function getValueArray()
    {
        return array_values($this->attributes);
    }

    /**
     * get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * insert into attributes
     *
     * @param array $attrs
     */
    public function setAttributes(array $attrs)
    {
        array_merge($this->attributes, $attrs);
    }
}