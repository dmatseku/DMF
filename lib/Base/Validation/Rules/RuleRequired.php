<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class   RuleRequired extends RuleSingleton
{
    protected function  __construct($params)
    {}

    public function     check(&$name, &$allInput, &$propertyRules)
    {
        return isset($allInput[$name]);
    }

    public function     getMessage(&$name, &$allInput)
    {
        return '"'.$name.'" is required.';
    }
}