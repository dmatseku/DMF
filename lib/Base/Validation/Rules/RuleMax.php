<?php


namespace lib\Base\Validation\Rules;


use lib\Base\Validation\Rule;

class RuleMax extends Rule
{
    /**
     * @var int limit
     */
    private int     $value = 0;
    /**
     * check as string
     *
     * @var bool
     */
    private bool    $isString = false;

    protected function  __construct($params)
    {
        if (is_numeric($params)) {
            $this->value = $params;
        } elseif (is_array($params) && isset($params[0]) && is_numeric($params[0])) {
            $this->value = $params[0];
        }
    }

    public function     check(string $name, array &$allInput, array &$propertyRules): bool
    {
        if (!isset($allInput[$name]) || is_null($allInput[$name])) {
            return true;
        }

        if ($this->isString = (is_string($allInput[$name]) && ((!array_key_exists('numeric', $propertyRules) &&
            array_key_exists('string', $propertyRules)) || !is_numeric($allInput[$name])))) {

            return strlen($allInput[$name]) <= $this->value;
        }
        return $allInput[$name] <= $this->value;
    }

    public function     getMessage(string $name, array &$allInput): string
    {
        if ($this->isString) {
            return '"'.$name.'" must be no longer than '.$this->value.' characters.';
        }
        return '"'.$name.'" must not exceed '.$this->value;
    }
}