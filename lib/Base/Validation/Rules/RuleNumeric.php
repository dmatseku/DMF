<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class   RuleNumeric extends RuleSingleton
{
    protected function  __construct($params)
    {}

    public function     check(string $name, array &$allInput, array &$propertyRules): bool
    {
        return (!isset($allInput[$name]) || is_null($allInput[$name])) || is_numeric($allInput[$name]);
    }

    public function     getMessage(string $name, array &$allInput): string
    {
        return '"'.$name.'" must be a number';
    }
}