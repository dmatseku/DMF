<?php


namespace   lib\Base\Validation;


abstract class  Rule
{
    abstract public function    check(&$name, &$allInput, &$propertyRules);

    abstract public function    getMessage(&$name, &$allInput);

    abstract protected function __construct($params);

    public static function      get($params)
    {
        return new static($params);
    }

    private static function     findRule($ruleName)
    {
        $class = 'app\\Rules\\Rule'.ucfirst($ruleName);
        if (class_exists($class) && is_subclass_of($class, self::class)) {
            return $class;
        }

        $class = 'lib\\Base\\Validation\\Rules\\Rule'.ucfirst($ruleName);
        if (class_exists($class) && is_subclass_of($class, self::class)) {
            return $class;
        }

        throw new \RuntimeException('Rule "'.$ruleName.'" doesn\'t exists or class isn\'t rule', 500);
    }

    public static function      createRulesArray($rulesArray)
    {
        $res = [];

        foreach ($rulesArray as $rule => $params) {
            if (!is_string($rule) && is_string($params)) {
                $delimiter = strpos($params, ':');

                if ($delimiter) {
                    $rule = substr($params, 0, $delimiter);
                    $params = explode(',', substr($params, $delimiter + 1));
                } else {
                    $rule = $params;
                    $params = null;
                }
            }

            $ruleClass = self::findRule($rule);
            $res[$rule] = $ruleClass::get($params);
        }

        return $res;
    }
}