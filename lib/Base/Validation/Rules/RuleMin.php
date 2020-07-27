<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\Rule;

class   RuleMin extends Rule
{
    protected   $value = 0;
    protected   $isString = false;

    protected function  __construct($params)
    {
        if (!is_null($params)) {
            if (is_numeric($params)) {
                $this->value = $params;
            } elseif (is_array($params) && isset($params[0]) && is_numeric($params[0])) {
                $this->value = $params[0];
            }
        }
    }

    public function     check(&$name, &$allInput, &$propertyRules)
    {
        if (!isset($allInput[$name]) || is_null($allInput[$name])) {
            return true;
        }

        if ($this->isString = (is_string($allInput[$name]) && ((!array_key_exists('numeric', $propertyRules) &&
            array_key_exists('string', $propertyRules)) || !is_numeric($allInput[$name])))) {

            return strlen($allInput[$name]) >= $this->value;
        }
        return $allInput[$name] >= $this->value;
    }

    public function     getMessage(&$name, &$allInput)
    {
        if ($this->isString) {
            return '"'.$name.'" must have at least '.$this->value.' characters.';
        }
        return '"'.$name.'" must be at least '.$this->value;
    }
}