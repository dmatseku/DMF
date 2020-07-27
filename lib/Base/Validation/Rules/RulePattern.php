<?php


namespace   lib\Base\Validation\Rules;


use lib\Base\Validation\Rule;

class   RulePattern extends Rule
{
    protected $regex = '//';

    public function __construct($params)
    {
        if (!is_null($params)) {
            if (is_string($params)) {
                $this->regex = $params;
            } elseif (is_array($params)) {
                if (isset($params[0]) && is_string($params[0])) {
                    $this->regex = $params[0];
                }
            }
        }
    }

    public function check(&$name, &$allInput, &$propertyRules)
    {
        return (!isset($allInput[$name]) || is_null($allInput[$name])) ||
            !empty(preg_match($this->regex, $allInput[$name]));
    }

    public function getMessage(&$name, &$allInput)
    {
        return '"'.$name.'" does not match the pattern';
    }
}