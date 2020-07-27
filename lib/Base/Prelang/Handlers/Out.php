<?php


namespace lib\Base\Prelang\Handlers;


class Out extends \lib\Base\Prelang\Handler
{

    public function pattern()
    {
        //start: 1, name: 2, value: 3, end: 4, endname: 5
        return '/({({|\!))\s*([\S\s]+)\s*((}|\!)})/';
    }

    protected function getMacrosName(&$matches)
    {
        $name = $matches[2][0];
        if ($name = '{') {
            return $matches[5][0] === '}' ? $matches[2][0] : false;
        }
        return $matches[5][0] === $name ? $matches[2][0] : false;
    }
}