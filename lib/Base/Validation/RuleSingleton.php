<?php


namespace lib\Base\Validation;


abstract class  RuleSingleton extends Rule
{
    private static  $instances = [];

    protected function      __clone() { }
    public function         __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function  get($params)
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static($params);
        }

        return self::$instances[$class];
    }
}