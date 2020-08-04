<?php


namespace   lib\Base\Validation;


abstract class  Rule
{
    /**
     * check value
     *
     * @param string $name
     * @param array $allInput
     * @param array $propertyRules
     *
     * @return bool
     */
    abstract public function    check(string $name, array &$allInput, array &$propertyRules): bool;

    /**
     * get error message
     *
     * @param string $name
     * @param array $allInput
     *
     * @return string
     */
    abstract public function    getMessage(string $name, array &$allInput): string;

    abstract protected function __construct($params);

    /**
     * get instance of rule
     *
     * @param array|string $params
     *
     * @return static
     */
    public static function      get($params)
    {
        return new static($params);
    }

    /**
     * check is rule exist and return
     *
     * @param string $ruleName
     *
     * @return Rule
     */
    private static function     findRule(string $ruleName): string
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

    /**
     * create array of rules instances
     *
     * @param array $rules
     *
     * @return array
     */
    public static function      createRulesArray(array $rules): array
    {
        $res = [];

        foreach ($rules as $rule => $params) {
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