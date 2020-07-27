<?php


namespace lib\Base\Prelang\Handlers;


use lib\Base\Prelang\Handler;

class BaseCut extends Handler
{

    public function pattern()
    {
        // start: 1, name: 2, values: 3
        return '/(@(?!end)(\w*))\s*\(\s*((?:(?!\))[\s\S])*)\s*\)/';
    }

    protected function getMacrosName(&$matches)
    {
        return $matches[2][0];
    }
}