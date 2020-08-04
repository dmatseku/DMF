<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class   RuleRequired extends RuleSingleton
{
    protected function  __construct($params)
    {}

    public function     check(string $name, array &$allInput, array &$propertyRules): bool
    {
        return isset($allInput[$name]);
    }

    public function     getMessage(string $name, array &$allInput): string
    {
        return '"'.$name.'" is required.';
    }
}