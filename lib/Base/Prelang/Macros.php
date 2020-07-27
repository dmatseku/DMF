<?php


namespace   lib\Base\Prelang;


abstract class  Macros
{
    use ViewArgs;

    abstract public function    name();
    abstract public function    before(&$page, &$fragment);
    abstract public function    after(&$previous, &$page, &$resultMatches, &$fragment);
    abstract public function    finish(&$page, &$fragment);

    public function             __construct(&$args, $params)
    {
        if (is_array($args)) {
            $this->args = &$args;
        }
    }

    public static function      createArray(&$args, &$macrosArray, $appSpace, $selfSpace)
    {
        $result = [];

        foreach ($macrosArray as $key => $value) {
            $macros = $value;
            $params = [];
            if (is_string($key)) {
                $macros = $key;
                $params = $value;
            }

            $macrosClass = $appSpace.'\\Macros\\'.$macros;
            if (!class_exists($macrosClass) || !is_subclass_of($macrosClass, self::class)) {
                $macrosClass = $selfSpace.'\\Macros\\'.$macros;
                if (!class_exists($macrosClass) || !is_subclass_of($macrosClass, self::class)) {
                    throw new \RuntimeException('Macros of prelang does not exists', 500);
                }
            }

            $result[$macros] = new $macrosClass($args, $params);
        }

        return $result;
    }
}