<?php


namespace lib\Base\Prelang\Handlers;


use lib\Base\Prelang\Handler;

class BaseFullParam extends Handler
{

    public function pattern()
    {
        //start: 1, name: 2, params: 3, values: 4, end: 5, endname: 6
        return '/(@(?!end)(\w*))\s\(\s*([\s\S]*)\s*\)\s(\s*[\s\S]*\s*)(@end(\w*))/';
    }

    protected function getMacrosName(&$matches)
    {
        return $matches[2][0] === $matches[5][0] ? $matches[2][0] : false;
    }
}