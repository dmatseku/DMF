<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class   RuleNumeric extends RuleSingleton
{
    protected function  __construct($params)
    {}

    public function     check(&$name, &$allInput, &$propertyRules)
    {
        return (!isset($allInput[$name]) || is_null($allInput[$name])) || is_numeric($allInput[$name]);
    }

    public function     getMessage(&$name, &$allInput)
    {
        return '"'.$name.'" must be a number';
    }
}