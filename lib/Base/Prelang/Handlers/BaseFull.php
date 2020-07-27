<?php


namespace lib\Base\Prelang\Handlers;


use lib\Base\Prelang\Handler;

class BaseFull extends Handler
{

    public function pattern()
    {
        //start: 1, name: 2, values: 3, end: 4, endname: 5
        return '/(@(?!end)(\w*))\s+((?:(?!@end)[\s\S])*)\s*(@end(\w*))/';
    }

    protected function getMacrosName(&$matches)
    {
        return $matches[2][0] === $matches[5][0] ? $matches[2][0] : false;
    }
}