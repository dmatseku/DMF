<?php


namespace   lib\Base\Prelang;

use lib\Base\Prelang\Handlers;

abstract class  Handler
{
    use ViewArgs;

    protected   $macros = [];

    abstract public function    pattern();
    abstract protected function getMacrosName(&$matches);

    public function             __construct(&$args, &$macrosArray, $appSpace, $selfSpace)
    {
        if (is_array($args)) {
            $this->args = &$args;
        }

        if (is_array($macrosArray)) {
            $this->macros = Macros::createArray($args, $macrosArray, $appSpace, $selfSpace);
        }
    }

    public static function      createArray(&$args, &$handlers, $appSpace, $selfSpace)
    {
        $result = [];

        foreach ($handlers as $handler => $macros) {
            $handlerClass = $appSpace.'\\Handlers\\'.$handler;
            if (!class_exists($handlerClass)) {
                $handlerClass = $selfSpace.'\\Handlers\\'.$handler;
                if (!class_exists($handlerClass)) {
                    throw new \RuntimeException('Handler of prelang does not exists', 500);
                }
            }

            $result[$handler] = new $handlerClass($args, $macros, $appSpace, $selfSpace);
        }

        return $result;
    }

    public function             before(&$page, &$matches, $macrosArray)
    {
        foreach ($macrosArray as $macros) {
            $macros = $this->macros[$macros];

            foreach ($matches as $fragment) {
                if ($macros->name() === $this->getMacrosName($fragment)) {
                    $macros->before($page, $fragment);
                }
            }
        }
    }

    public function             after(&$previous, &$page, &$resultMatches, &$pageMatches, $macrosArray)
    {
        foreach ($macrosArray as $macros) {
            $macros = $this->macros[$macros];

            foreach ($pageMatches as $fragment) {
                if ($macros->name() === $this->getMacrosName($fragment)) {
                    $macros->after($previous, $page, $resultMatches, $fragment);
                }
            }
        }
    }

    public function             finish(&$page, &$matches, $macrosArray)
    {
        foreach ($macrosArray as $macros) {
            $macros = $this->macros[$macros];

            foreach ($matches as $fragment) {
                if ($macros->name() === $this->getMacrosName($fragment)) {
                    $macros->finish($page, $fragment);
                }
            }
        }
    }

    public function             clean(&$page)
    {
        $pattern = $this->pattern();

        $page = preg_replace($pattern, '', $page);
    }
}