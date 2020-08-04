<?php


namespace lib\Base\Validation;


abstract class  RuleSingleton extends Rule
{
    /**
     * @var array singleton instances
     */
    private static array    $instances = [];

    protected function      __clone() { }
    public function         __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * get instance
     *
     * @param mixed $params
     *
     * @return RuleSingleton
     */
    public static function  get($params): RuleSingleton
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static($params);
        }

        return self::$instances[$class];
    }
}