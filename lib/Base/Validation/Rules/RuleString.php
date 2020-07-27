<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class   RuleString extends RuleSingleton
{
    protected function  __construct($params)
    {}

    public function     check(&$name, &$allInput, &$propertyRules)
    {
        return (!isset($allInput[$name]) || is_null($allInput[$name])) || is_string($allInput[$name]);
    }

    public function     getMessage(&$name, &$allInput)
    {
        return '"'.$name.'" must be a string.';
    }
}