<?php


namespace lib\Base\Validation\Rules;


use lib\Base\Validation\RuleSingleton;

class RuleNotempty extends RuleSingleton
{
    public function __construct($params)
    {}

    /**
     * @inheritDoc
     */
    public function check(string $name, array &$allInput, array &$propertyRules): bool
    {
        return !isset($allInput[$name]) || !empty($allInput[$name]);
    }

    /**
     * @inheritDoc
     */
    public function getMessage(string $name, array &$allInput): string
    {
        return "\"$name\" can't be empty";
    }
}